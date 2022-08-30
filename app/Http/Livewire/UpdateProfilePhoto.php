<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;

class UpdateProfilePhoto extends Component
{

    public $user;

    public function mount(){
        $this->user = Auth::user();
    }
    public function render()
    {
        return view('livewire.update-profile-photo');
    }

    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');


    }
}
