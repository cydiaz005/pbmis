<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Office;
use App\Models\Mfo;

class OfficeMfos extends Component
{
    public $mfos;
    public $office;
    public $office_id;
    public function render()
    {
        $this->mfoBuilder();
        return view('livewire.office-mfos');
    }
  
    public function mfoBuilder()
    {
        $this->office = Office::find($this->office_id);
        $this->mfos = Mfo::all();
        $this->activeMfos = $this->office->mfos;
    }
}
