<?php

namespace App\Http\Livewire\Mail;

use Livewire\Component;

class Sent extends Component
{
    public function render()
    {
        return view('livewire.mail.sent');
    }
    public function readMail()
    {
        return redirect('mail/read-mail');
    }
}
