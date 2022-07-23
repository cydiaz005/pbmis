<?php

namespace App\Http\Livewire\FileManager;

use Livewire\Component;
use App\Models\ServiceRegion;
use App\Models\Stage;
use App\Models\FormPoe;
use App\Models\FormPpmp;



class Reports extends Component
{
    public $filter;
    public $params;
    public $lists;
    public $stages;
    public $service_regions;

    public function render()
    {
        return view('livewire.file-manager.reports');
    }

    public function mount()
    {
        
        $this->stages = Stage::all();
        $this->service_regions = ServiceRegion::all();
        $this->filter = [
            "search" => null, 
            "stage" =>  $this->stages->where('active', '1')->pluck('id')->first(), 
            "region" => 1, 
            "month" => date('m'), 
            "year" => date('Y')
        ];
        $this->getForms();

    }

    public function getForms()
    {
        $lists = FormPoe::join('form_ppmps','form_ppmps.poe_id', 'form_poes.id')->with('serviceRegion');
        $lists->where('form_ppmps.funded','1');
        $this->lists = $lists->get();

        // ($this->filter['year']!="")  ? $lists->whereYear('created_at', '=', $this->filter['year']): null;
        // ($this->filter['month']!="") ? $lists->whereMonth('created_at', '=', $this->filter['month']): null;
        // ($this->filter['region']!="") ? $lists->where('service_region_id', $this->filter['region']): null;
        // ($this->filter['search']) ? $lists->where('name',  'like', $this->filter['search']):0;
        // ($this->filter['year']) ? $lists = $lists->whereYear('created_at', '=', $this->filter['year']):0;
        // ($this->filter['month']) ?$lists =  $lists->whereMonth('created_at', '=', $this->filter['month']):0;
        // ($this->filter['stage']) ? $lists = $lists->where('stage_id',  $this->filter['stage']):0;
        // ($this->filter['region']) ? $lists = $lists->where('service_region_id',  $this->filter['region']):0;
    }


}
