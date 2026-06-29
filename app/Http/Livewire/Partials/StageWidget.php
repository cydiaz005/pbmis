<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class StageWidget extends Component
{
    public $ind;
    public $nep;
    public $gaa;
    public function render()
    {
        return view('livewire.partials.stage-widget');
    }
}
