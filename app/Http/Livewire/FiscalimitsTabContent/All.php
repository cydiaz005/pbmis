<?php

namespace App\Http\Livewire\FiscalimitsTabContent;

use Livewire\Component;
use App\Models\FiscalLimit;
use Illuminate\Support\Facades\DB;

class All extends Component
{
    public $year;
    public $fiscal_limit_list;
    public function render()
    {
        $this->year = date('Y');
        $this->fiscal_limit_list = FiscalLimit::groupBy(DB::raw("DATE_FORMAT(created_at, '%Y')"))
        ->get();
        // $fiscal_limit_list = FiscalLimit::all();
        return view('livewire.fiscalimits-tab-content.all');
    }
}
