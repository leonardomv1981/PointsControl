<?php

namespace App\Http\Controllers;

use App\Models\Balances;
use Illuminate\Http\Request;

class BalancesController extends Controller
{
    
    public function getBalace($data) {

        $balance = Balances::where('id_program', $data['program'])
            ->where('status', 'active');

        return $balance;
    }

}
