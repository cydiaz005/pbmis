<?php

namespace App\Http\Livewire\OpcTabContent;
use App\Models\FormOpc;

use Livewire\Component;

class All extends Component
{
    public $opcs;

    public function mount(){
        $this->opcs =  FormOpc::with(['serviceRegion','creator'])->get();
    }
    public function render()
    {
        return view('livewire.opc-tab-content.all');
    }
}
