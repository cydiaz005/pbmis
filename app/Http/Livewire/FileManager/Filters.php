<?php

namespace App\Http\Livewire\FileManager;

use Livewire\Component;
use App\Models\Stage;
use App\Models\FormPoe;
use App\Models\ServiceRegion;
use Illuminate\Support\Facades\Auth;

class Filters extends Component
{

    public $params;
    public $lists;
    public $stages;
    public $service_regions;
    

    public $filter_search;
    public $filter_stage;
    public $filter_serreg;
    public $filter_year;
    public $filter_month;


    public function render()
    {
        return view('livewire.file-manager.filters');
    }
    public function mount()
    {
        $this->stages = Stage::all();
        $this->service_regions = ServiceRegion::all();
        $this->filter_search = '';
        $this->filter_stage = $this->stages->where('active', '1')->pluck('id')->first();
        $this->filter_serreg = Auth::user()->serreg_id;
        $this->filter_year = date('Y');
        $this->filter_month = date('m');
    }
    public function updated()
    {
        $filters = [
            'search' => $this->filter_search,
            'stage' => $this->filter_stage,
            'serreg' => $this->filter_serreg,
            'year' => $this->filter_year,
            'month' => $this->filter_month,
        ];

        
        $this->emit('filter_changed', $filters);
    }


}
