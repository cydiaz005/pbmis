<?php

namespace App\Http\Livewire\OpcTabContent;
use App\Models\FormOpc;

use Livewire\Component;

class Draft extends Component
{
    public $opcs;

    public function mount(){
        $this->opcs =  FormOpc::with(['serviceRegion','creator'])->where('status_id',1)->get();
    }

    public function render()
    {
        return view('livewire.opc-tab-content.draft');
    }
}
