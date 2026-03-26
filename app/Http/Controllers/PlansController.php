<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\Userplans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlansController extends Controller
{

    public function __construct(Plans $plan)
    {
        $this->plans = $plan;
    }
    
    public function index () {
        //declaração temporária de usuário:
        $myUser = 1;
        $data['plans'] = Plans::where('status', 'active')
        ->get();
        $data['myPlan'] = Userplans::where('id_user', $myUser)
                                   ->where('status', 'active')
                                   ->first();
        return view('plans.index', compact('data'));
    }

    public function subscribe (Request $request) {
        $data = $request->all();
        $actualPlan = Userplans::where('id_user', Auth::user()->id)
                               ->where('status', 'active')
                               ->first();
        if ($actualPlan) {
            $actualPlan->status = 'inactive';
            $actualPlan->save();
        }
        $newPlan = new Userplans();
        $newPlan->id_user = Auth::user()->id;
        $newPlan->id_plan = $data['id_plan'];
        $newPlan->status = 'active';
        $newPlan->save();
        return redirect()->route('plans.index');
    }
}
