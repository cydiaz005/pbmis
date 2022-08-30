<?php

namespace App\Http\Livewire\Mail;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class Inbox extends Component
{
    public function render()
    {
        return view('livewire.mail.inbox');
    }
    public function readMail()
    {
        return redirect('mail/read-mail');
    }
}
