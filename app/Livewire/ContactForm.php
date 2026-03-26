<?php

namespace App\Livewire;

use App\Mail\Contactusmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|min:3|max:255',
        'message' => 'required|string|min:10|max:5000',
    ];



    public function render()
    {
        return view('livewire.contact-form');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function send() {
        $validatedDate = $this->validate();

        try {
            Mail::to('pointscontrolapp@gmail.com')->send(new Contactusmail($validatedDate));

            Session()->flash('success', 'Mensagem enviada com sucesso!');
        } catch (\Throwable $th) {
            dd($th);
            $this->addError('email', 'Erro ao enviar o e-mail. Tente novamente mais tarde.');
            return;
        }

        

        $this->reset();
    }

}
