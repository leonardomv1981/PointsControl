<?php

namespace App\Livewire\Trips;

use App\Models\Mytrips;
use Livewire\Component;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    protected $listeners = ['trip-created' => '$refresh'];

    public function delete($id)
    {
        $trip = Mytrips::find($id);
        if ($trip->id_user != Auth::user()->id) {
            return redirect()->route('trips.index')->with('error', 'You do not have permission to delete this trip.');
        }
        Mytrips::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.trips.index', [
            'trip' => Mytrips::where('user_id', Auth::user()->id)->latest()->first()
        ]);
    }
}