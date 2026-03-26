<?php

namespace App\Livewire\Trips;

use Livewire\Component;
use App\Models\Trip;
use App\Models\Trips;
use Illuminate\Support\Facades\Auth;

class CreateTripModal extends Component
{
    public $isOpen = false;
    public $showModal = false;
    public $name;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);


        Trips::create([
            'trip_name' => $this->name,
            'id_user' => Auth::id(),
            'status' => 'active',
        ]);

        $this->closeModal();
        return redirect()->route('trips.index', ['locale' => app()->getLocale()]);

    }

    public function render()
    {
        return view('livewire.trips.create-trip-modal');
    }
}