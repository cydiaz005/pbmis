<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class FlashMessages extends Component
{
    public $parent_id;
    public function render()
    {
        return view('livewire.components.flash-messages');
    }
}
