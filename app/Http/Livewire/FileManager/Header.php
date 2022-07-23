<?php

namespace App\Http\Livewire\FileManager;

use Livewire\Component;
use App\Models\ServiceRegion;
use App\Models\Stage;


class Header extends Component
{

    public $service_regions;
    public $stages;

    public function render()
    {
        $this->getFilters();
        return view('livewire.file-manager.header');
    }

    public function getFilters()
    {
        $this->service_regions = ServiceRegion::all();
        $this->stages = Stage::all();
    }
}
