<?php

namespace App\Http\Livewire\OpcTabContent;
use App\Models\FormOpc;

use Livewire\Component;

class Returned extends Component
{
    public $opcs;

    public function mount(){
        $this->opcs =  FormOpc::with(['serviceRegion','creator'])->where('status_id',4)->get();
    }

    public function render()
    {
        return view('livewire.opc-tab-content.returned');
    }
}
