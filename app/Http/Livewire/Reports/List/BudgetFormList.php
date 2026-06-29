<?php

namespace App\Http\Livewire\Reports\List;

use Livewire\Component;
use App\Models\FormPoe;
use App\Models\FormPpmp;
use Illuminate\Support\Facades\Auth;

class BudgetFormList extends Component
{
    public $fund; 
    public $list = []; 
    public $params = []; 
    protected $listeners = ['filter_changed' => 'filter_changed'];

    public function filter_changed($params)
    {

        $this->params = $params;
        $lists = FormPoe::join('form_ppmps','form_ppmps.poe_id', 'form_poes.id')
        ->with('serviceRegion')
        ->where('form_ppmps.funded','0')
        ->where('form_poes.stage_id', $params["stage"]);

        // ($params['serreg'])  ? $lists->where('form_poes.service_region_id',  $params['serreg']): null;
        ($params['year']!="")  ? $lists->whereYear('form_ppmps.created_at', '=', $params['year']): null;
        ($params['month']!="") ? $lists->whereMonth('form_ppmps.created_at', '=', $params['month']): null;
        $this->lists = $lists->get();
        $this->emit('newList');

    }
    
    public function render()
    {
        return view('livewire.reports.list.budget-form-list');
    }

    public function mount()
    {
        $params = [
            'search' => null,
            'stage' => 1,
            'serreg' => Auth::user()->serreg_id,
            'year' => date('Y'),
            'month' => date('m'),
        ];

        $this->filter_changed($params);

    }
}
