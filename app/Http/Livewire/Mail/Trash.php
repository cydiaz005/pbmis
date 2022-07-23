<?php

namespace App\Http\Livewire\Mail;

use Livewire\Component;

class Trash extends Component
{
    public function render()
    {
        return view('livewire.mail.trash');
    }
    public function readMail()
    {
        return redirect('mail/read-mail');
    }
}
