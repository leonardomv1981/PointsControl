<?php

namespace App\Http\Controllers;

use App\Models\invite;
use App\Models\Programs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\InviteUserMail;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function registerInvite(Request $request) {

        $email = $request->all()['email'];
        $checkEmail = invite::where('email', $email)
        ->first();
        $checkEmailRegistered = User::where('email', $email)
        ->first();

        // dd($checkEmail);

        if (is_null($checkEmail) && is_null($checkEmailRegistered)) {
            $invite = new invite();
            $invite->email = $request->all()['email'];
            $invite->token = Str::random(10);
            $invite->save();
            $data['response'] = 'success';
            $data['message'] =  __('general.emailInviteOk');
        } else {
            $data['response'] = 'warning';
            $data['message'] = __('general.emailAlreadyRegistered');
        }

        // Auth::login($user);


        return view('auth.register', compact('data'));
    }

    public function contact(Request $request) {
        $data = $request->all();
        
        Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
            $message->to('recipient@example.com') // Replace with the recipient's email
                    ->subject('New Contact Message')
                    ->from($data['email'], $data['name']); // Assuming 'email' and 'name' are part of $data
        });

        return view('contact', compact('data'));
    }

    public function allCalculator() {

        $data['programs'] = Programs::where('id_user', Auth::user()->id)
        ->where('programs.status', 'active')
        ->orderBy('program_name', 'asc')
        ->join('balances', 'programs.id', '=', 'balances.id_program')
        ->leftJoin('signature_clubs', 'programs.id', '=', 'signature_clubs.id_program')
        ->select(
        'programs.*',
        'balances.total_points',
        'balances.total_value',
        DB::raw("CASE WHEN signature_clubs.id_program IS NOT NULL THEN true ELSE false END as signature_club")
        )
        ->get();

        return view('calculators.all', compact('data'));
    }

    public function pointsAndMoneyCalculator() {
        $data['programs'] = Programs::where('id_user', Auth::user()->id)
        ->where('programs.status', 'active')
        ->orderBy('program_name', 'asc')
        ->join('balances', 'programs.id', '=', 'balances.id_program')
        ->leftJoin('signature_clubs', 'programs.id', '=', 'signature_clubs.id_program')
        ->select(
        'programs.*',
        'balances.total_points',
        'balances.total_value',
        DB::raw("CASE WHEN signature_clubs.id_program IS NOT NULL THEN true ELSE false END as signature_club")
        )
        ->get();

        return view('calculators.pointsmoney', compact('data'));
    }

    public function inviteSend(Request $request) {

        $idInvite = $request->input('id');

        $invite = Invite::where('id', $idInvite)->first();
        
        $email = $invite->email;
        $token = $invite->token;
        $locale = $request->route('locale') ?? 'pt';

        // Enviar e-mail
        try {
            Mail::to($email)->send(new InviteUserMail($token, $locale));

            $invite->inviteSent = now();
            $invite->save();

            return response()->json([
                'response' => 'success',
                'message'  => 'Invite sent successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error("Error sending invite: " . $e->getMessage());

            return response()->json([
                'response' => 'error',
                'message'  => 'Failed to send invite!'
            ], 500);
        }

        // return back()->with('success', 'Convite enviado com sucesso!');

    }

    public function inviteIndex() {
        $data['invites'] = invite::all();
        return view('invites.index', compact('data'));
    }

    // public function registerIndex(Request $request) {
    //     if (!$request->has('token')) {
    //         return view('auth.register');
    //     } 
    //     $token = $request->all()['token'];

    //     $data = invite::where('token', $token)->first();

    //     return view('auth.register', compact('data'));
        

    // }
}
