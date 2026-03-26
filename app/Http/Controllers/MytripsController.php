<?php

namespace App\Http\Controllers;

use App\Models\Mytrips;
use App\Models\Trips;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MytripsController extends Controller
{
    public function index () {

        $trips = Trips::where('id_user', Auth::id())
            ->where('status', 'active')
            ->get();
    
        return view('mytrips.index', compact('trips'));
    }
}
