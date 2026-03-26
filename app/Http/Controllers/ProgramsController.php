<?php

namespace App\Http\Controllers;

use App\Models\Balances;
use App\Models\Loungescards;
use App\Models\Programs;
use App\Models\SignatureClub;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramsController extends Controller
{
    public function index () {
        $data['programs'] = Programs::where('id_user', Auth::user()->id)
            ->where('programs.status', 'active')
            ->orderBy('program_name', 'asc')
            ->join('balances', 'programs.id', '=', 'balances.id_program')
            ->leftJoin('signature_clubs', function ($join) {
            $join->on('programs.id', '=', 'signature_clubs.id_program')
                 ->where('signature_clubs.status', '=', 'active');
            })
            ->select(
            'programs.*',
            'balances.total_points',
            'balances.total_value',
            DB::raw("CASE WHEN signature_clubs.id_program IS NOT NULL THEN true ELSE false END as signature_club")
            )
            ->get();

        $data['user'] = Auth::user();

        return view('programs.index', compact('data'));
    }

    public function add(Request $request) {
        if ($request->method() == 'GET') {
            $data = $request->all();
            if (isset($data['id'])) {
                $program = Programs::where('id', $data['id'])
                ->where('status', 'active')
                ->where('id_user', Auth::user()->id)
                ->first();

                if (!$program) {
                    return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
                }

                if ($program->id_user != Auth::user()->id) {
                    return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
                }

                $data['program'] = $program;
                $data['user'] = Auth::user();
                $data['signature_club'] = SignatureClub::where('id_program', $data['id'])
                ->where('status', 'active')
                ->first();
            if ($data['signature_club'] == null) {
                $data['signature_club'] = [];
            }
                return view('programs.add', compact('data'));
            }
            $data['program'] = [];
            $data['user'] = Auth::user();
            $data['signature_club'] = [];
            return view('programs.add', compact('data'));

        } else if ($request->method() == 'POST') {

            $data = $request['data'];
            if ($data['program']['id']) {

                $program = Programs::where('id', $data['program']['id'])
                ->where('status', 'active')
                ->first();

                if (!$program) {
                    return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
                }

                if ($program->id_user != Auth::user()->id) {
                    return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
                }

                // atualiza os dados
                $exists = Programs::where('program_name', $data['program']['name'])
                ->where('id', '!=', $data['program']['id'])
                ->where('id_user', Auth::user()->id)
                ->where('status', 'active')
                ->exists();

                if ($exists) {
                    return redirect()->back()->withErrors([__('programs.errorProgramExists') . ' ' . $data['program']['name']]);
                }

                $cpmValue = preg_replace('/[\s\x{00A0}]+/u', '', $data['program']['cpm_value']);
                if ($data['currency'] == 'brl' && $cpmValue != '') {
                    $cpmValue = str_replace(['R$', '.', ','], ['', '', '.'], $cpmValue);
                }
                elseif ($data['currency'] == 'usd' && $cpmValue != '') {
                    $cpmValue = str_replace(['$', ','], ['', ''], $cpmValue);
                } else if ($cpmValue == '') {
                    $cpmValue = 0;
                }

                $program->program_name = $data['program']['name'];
                $program->points_validity = $data['program']['validity'];
                $program->cpm_value = $cpmValue;
                $program->status = $data['program']['status'];
                $program->save();
                
                $signatureClub = SignatureClub::where('id_program', $program->id)
                ->where('status', 'active')
                ->exists();
                
                if (isset($data['signature_club']['status'])) {
                
                    if ($data['signature_club']['day'] == null) {
                        return redirect()->back()
                        ->withErrors([__('programs.errorDayRequired')])
                        ->withInput();
                    }

                    if ($data['signature_club']['points'] == null) {
                        return redirect()->back()
                        ->withErrors([__('programs.errorPointsRequired')])
                        ->withInput();
                    } else {
                        $data['signature_club']['points'] = str_replace([',', '.'], '', $data['signature_club']['points']);
                    }
                    
                    if ($data['signature_club']['club_value'] == null) {
                        $data['signature_club']['club_value'] = 0;
                    } else {
                        $value = $data['signature_club']['club_value'];
                    
                        $value = preg_replace('/[\s\x{00A0}]+/u', '', $value);
                    
                        if ($data['currency'] == 'brl') {
                            $value = str_replace(['R$', '.', ','], ['', '', '.'], $value);
                        }
                        elseif ($data['currency'] == 'usd') {
                            $value = str_replace(['$', ','], ['', ''], $value);
                        }
                    
                        $data['signature_club']['club_value'] = $value;
                    }

                    //vai atualizar o clube de assinatura
                    if ($signatureClub && $data['signature_club']['status'] == true) {
                        
                        $signatureClub = SignatureClub::where('id_program', $program->id)
                        ->where('status', 'active')
                        ->first();
                        $signatureClub->id_program = $program->id;
                        $signatureClub->points = $data['signature_club']['points'];
                        $signatureClub->club_value = $data['signature_club']['club_value'];
                        $signatureClub->day = $data['signature_club']['day'];
                        $signatureClub->status = $data['signature_club']['status'];
                        $signatureClub->save();
                    }

                    //vai criar o clube de assinatura
                    if (!$signatureClub && $data['signature_club']['status'] == true) {
                        $signatureClub = new SignatureClub();
                        $signatureClub->id_program = $program->id;
                        $signatureClub->points = $data['signature_club']['points'];
                        $signatureClub->club_value = $data['signature_club']['club_value'];
                        $signatureClub->day = $data['signature_club']['day'];
                        $signatureClub->status = $data['signature_club']['status'];
                        $signatureClub->save();
                    }
                } else {
                    //vai apagar o clube de assinatura
                    if ($signatureClub) {
                        $signatureClub = SignatureClub::where('id_program', $program->id)
                        ->where('status', 'active')
                        ->first();
                        $signatureClub->status = 'deleted';
                        $signatureClub->save();
                    }
                }

                return redirect()->route('programs.index', ['locale' => $request->route('locale')]);

                //cria programa
            } else {
                $exists = Programs::where('program_name', $data['program']['name'])
                    ->where('id_user', Auth::user()->id)
                    ->where('status', 'active')
                    ->exists();
                if ($exists) {
                    // dd($data);
                    return redirect()->back()->withErrors([__('programs.errorProgramExists') . ' ' . $data['program']['name']]);
                }

                $cpmValue = preg_replace('/[\s\x{00A0}]+/u', '', $data['program']['cpm_value']);
                if ($data['currency'] == 'brl') {
                    $cpmValue = str_replace(['R$', '.', ','], ['', '', '.'], $cpmValue);
                }
                elseif ($data['currency'] == 'usd') {
                    $cpmValue = str_replace(['$', ','], ['', ''], $cpmValue);
                }

                if ($cpmValue == '') {
                    $cpmValue = 0;
                }

                $program = new Programs();
                $program->program_name = $data['program']['name'];
                $program->points_validity = $data['program']['validity'];
                $program->cpm_value = $cpmValue;
                $program->id_user = Auth::user()->id;
                $program->status = 'active';
                $program->save();
                
                $balance = new Balances();
                $balance->id_program = $program->id;
                $balance->total_points = 0;
                $balance->total_value = 0;
                $balance->status = 'active';
                $balance->save();

                if (isset($data['signature_club']['status'])) {

                    if ($data['signature_club']['day'] == null) {
                        return redirect()->back()
                        ->withErrors([__('programs.errorDayRequired')])
                        ->withInput();
                    }

                    if ($data['signature_club']['points'] == null) {
                        return redirect()->back()
                        ->withErrors([__('programs.errorPointsRequired')])
                        ->withInput();
                    } else {
                        $data['signature_club']['points'] = str_replace([',', '.'], '', $data['signature_club']['points']);
                    }
                    
                    if ($data['signature_club']['club_value'] == null) {
                        $data['signature_club']['club_value'] = 0;
                    } else {
                        $value = $data['signature_club']['club_value'];
                    
                        $value = preg_replace('/[\s\x{00A0}]+/u', '', $value);
                    
                        if ($data['currency'] == 'brl') {
                            $value = str_replace(['R$', '.', ','], ['', '', '.'], $value);
                        }
                        elseif ($data['currency'] == 'usd') {
                            $value = str_replace(['$', ','], ['', ''], $value);
                        }
                    
                        $data['signature_club']['club_value'] = $value;
                    }

                    $signatureClub = new SignatureClub();
                    $signatureClub->id_program = $program->id;
                    $signatureClub->points = $data['signature_club']['points'];
                    $signatureClub->club_value = $data['signature_club']['club_value'];
                    $signatureClub->day = $data['signature_club']['day'];
                    $signatureClub->status = $data['signature_club']['status'];
                    $signatureClub->save();
                }
            }
            
            return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
        }
    }

    public function delete(Request $request) {
        $data = $request->json()->all();
        $program = Programs::where('id', $data['id'])
        ->where('status', 'active')
        ->where('id_user', Auth::user()->id)
        ->first();
        if (!$program) {
            return response()->json(['status' => 'error']);
        }
        if ($program->id_user != Auth::user()->id) {
            return response()->json(['status' => 'error']);
        }
        $program->status = 'deleted';
        $program->save();

        $balance = Balances::where('id_program', $data['id'])
        ->where('status', 'active')
        ->get();
        $balance[0]->status = 'deleted';
        $balance[0]->save();

        $signatureClub = SignatureClub::where('id_program', $data['id'])
        ->where('status', 'active')
        ->get();

        if ($signatureClub->count() > 0) {
            $signatureClub[0]->status = 'deleted';
            $signatureClub[0]->save();
        }

        $transactions = Transactions::where('id_program', $data['id'])->get();
        foreach ($transactions as $transaction) {
            $transaction->status = 'deleted';
            $transaction->save();
        }

        return response()->json(['status' => 'success']);

    }

    public function balance(Request $request) {
        $data = $request->all()['data'];

        if (isset($data['program']['period'])) {
            $period = $data['program']['period'];
        } else {
            $period = '30';
        };

        $data['program'] = Balances::where('id_program', $data['program']['id'])
        ->where('balances.status', 'active')
        ->join('programs', 'programs.id', '=', 'balances.id_program')
        ->select('programs.*', 'balances.total_points', 'balances.total_value')
        ->get();
        $data['user'] = User::where('id', Auth::user()->id)
        ->where('status', 'active')
        ->select( 'id', 'first_name', 'language', 'currency', 'date_format')
        ->first();

        $data['program'] = $data['program'][0];
        
        $data['signature_club'] = SignatureClub::where('id_program', $data['program']['id'])
        ->where('status', 'active')
        ->first();
        
        if ($data['program']['id_user'] != Auth::user()->id) {
            $data = '';
            $data['programs'] = Programs::where('id_user', Auth::user()->id)
            ->where('programs.status', 'active')
            ->orderBy('program_name', 'asc')
            ->join('balances', 'programs.id', '=', 'balances.id_program')
            ->select('programs.*', 'balances.total_points', 'balances.total_value')
            ->get();

            $data['error'] = __('general.authFailed');

            return view('programs.index', compact('data'));
        }


        switch ($period) {
            case '60':
                $data['transactions'] = Transactions::where('id_program', $data['program']['id'])
                ->where('transactions.status', 'active')
                ->where('date', '>=', \Carbon\Carbon::now()->subDays(60))
                ->orderBy('date', 'desc')
                ->get();
                $data['program']['period'] = '60';
                break;
            case 'all':
                $data['transactions'] = Transactions::where('id_program', $data['program']['id'])
                ->where('transactions.status', 'active')
                ->orderBy('date', 'desc')
                ->get();
                $data['program']['period'] = 'all';
                break;
            default:
                $data['transactions'] = Transactions::where('id_program', $data['program']['id'])
                ->where('transactions.status', 'active')
                ->where('date', '>=', \Carbon\Carbon::now()->subDays(30))
                ->orderBy('date', 'desc')
                ->get();
                $data['program']['period'] = '30';
                break;
        };
        
        return view('programs.balance', compact('data'));
    }

    public function dashboard() {
        $data['balance'] = Balances::whereIn('id_program', function ($query) {
            $query->select('id')
            ->from('programs')
            ->where('id_user', Auth::user()->id)
            ->where('status', 'active');
        })
        ->where('status', 'active')
        ->select(
            DB::raw('SUM(total_points) as total_points'),
            DB::raw('SUM(total_value) as total_value')
        )
        ->first();

        $data['program_count'] = Programs::where('id_user', Auth::user()->id)
            ->where('status', 'active')
            ->count();

        $data['user'] = User::where('id', Auth::user()->id)
            ->where('status', 'active')
            ->select('id', 'first_name', 'language', 'currency', 'date_format')
            ->first();

        $data['lounges'] = Loungescards::where('id_user', Auth::user()->id)
            ->where('status', 'active')
            ->select(
            DB::raw('COUNT(id) as total_count'),
            DB::raw('SUM(access_own) - SUM(access_own_used) as total_remaining_access')
            )
            ->first();

        // dd($data['balance']);

        return view('dashboard', compact('data'));
    }
}
