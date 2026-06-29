<?php

namespace App\Http\Livewire\Analytics;

use Livewire\Component;
use App\Models\FundChargeability;
use App\Models\FiscalLimit;
use App\Models\ServiceRegion;
use App\Models\Stage;


class AnalyticsFiscalLimit extends Component
{
    public $fiscal_limit;
    public $allotment_class;
    public $fund_chargeability;
    public $fund_chargeability_class;
    public $service_region;
    public $stages;




    public function render()
    {
        return view('livewire.analytics.analytics-fiscal-limit');
    }
    public function mount()
    {
        $current = date('Y');
        $this->fund_chargeability = FundChargeability::whereHas('fundChargeabilityClass.allotmentClass')->get();
        $service_region = ServiceRegion::all();
        $this->stages = Stage::orderBy('active','desc')->get();
        $this->fiscal_limit = FiscalLimit::whereYear('created_at', '=', $current)
        ->with('serviceRegion','category.allotmentClass','category.fundChargeability')->get();

        

    }
    
}
