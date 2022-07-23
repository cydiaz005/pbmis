<?php

namespace App\Http\Livewire\Mail;

use Livewire\Component;

class Draft extends Component
{
    public function render()
    {
        return view('livewire.mail.draft');
    }
    public function readMail()
    {
        return redirect('mail/read-mail');
    }
}
