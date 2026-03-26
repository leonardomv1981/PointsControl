<?php

namespace App\Http\Controllers;

use App\Models\Cardflag;
use App\Models\Loungesaccess;
use App\Models\Loungescards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoungecardsController extends Controller
{
    public function index() {
        $data['loungecards'] = Loungescards::where('loungescards.id_user', Auth::id())
        ->where('loungescards.status', 'active')
        ->join('cardflags', 'loungescards.id_cardflag', '=', 'cardflags.id')
        ->select('loungescards.*', 'cardflags.flag')
        ->get();

        return view('lounges.index', compact('data'));
    }
    
    public function add(Request $request) {
        if ($request->method() == 'GET') {
            $data['cardBrands'] = Cardflag::where('status', 'active')
            ->orderBy('flag')
            ->get();
            if (isset($request->all()['id'])) {
                $data['loungecards'] = Loungescards::where('id', $request->all()['id'])
                ->where('id_user', Auth::id())
                ->where('status', 'active')
                ->first();
                if (!$data['loungecards']) {
                    return redirect()->route('lounges.index');
                }
                return view('lounges.add', compact('data'));

            } else {
                return view('lounges.add', compact('data'));
            }
        } else if ($request->method() == 'POST') {
            if ($request->all()['data']['loungecards']['id']) {
                $loungecard = Loungescards::where('id', $request->all()['data']['loungecards']['id'])
                ->where('id_user', Auth::id())
                ->where('status', 'active')
                ->first();
                if (!$loungecard) {
                    return redirect()->route('lounges.index');
                }
                $loungecard->id_cardflag = $request->all()['data']['loungecards']['cardBrand'];
                $loungecard->name = $request->all()['data']['loungecards']['name'];
                $loungecard->login = $request->all()['data']['loungecards']['login'];
                $loungecard->access_own = $request->all()['data']['loungecards']['access_own'];
                $loungecard->save();
                return redirect()->route('lounges.index');
            } else {
                $data = $request->all()['data'];
                // dd($data['loungecards']);
                $loungecard = new Loungescards();
                $loungecard->id_user = Auth::id();
                $loungecard->id_cardflag = $data['loungecards']['cardBrand'];
                $loungecard->name = $data['loungecards']['name'];
                $loungecard->login = $data['loungecards']['login'];
                $loungecard->access_own = $data['loungecards']['access_own'];
                $loungecard->access_own_used = 0;
                $loungecard->status = 'active';
                $loungecard->save();
    
                return redirect()->route('lounges.index');
            }

        }

    }

    public function delete(Request $request) {
        $data = $request->json()->all();
        // dd($data);
        $loungecard = Loungescards::where('id', $data['id'])
        ->where('id_user', Auth::id())
        ->where('status', 'active')
        ->first();
        if (!$loungecard) {
            return response()->json(['status' => 'error']);
        }
        $loungecard->status = 'deleted';
        $loungecard->save();

        $loungesaccess = Loungesaccess::where('id_loungescard', $data['id'])
        ->where('status', 'active')
        ->get();
        foreach ($loungesaccess as $access) {
            $access->status = 'deleted';
            $access->save();
        }

        return response()->json(['status' => 'success']);
    }

    public function addAccess(Request $request) {
        $data = $request->json()->all();

        $loungecard = Loungescards::where('id', $data['id'])
        ->where('id_user', Auth::id())
        ->where('status', 'active')
        ->first();
        // dd($loungecard);
        if (!$loungecard) {
            return response()->json(['status' => 'error']);
        }
        $loungecard->access_own_used = $loungecard->access_own_used + $data['qtdAccess'];
        $loungecard->save();

        Loungesaccess::create([
            'id_loungescard' => $loungecard->id,
            'date' => date('Y-m-d'),
            'access_own' => $data['qtdAccess'],
            'status' => 'active'
        ]);

        return response()->json(['status' => 'success']);

    }
}
