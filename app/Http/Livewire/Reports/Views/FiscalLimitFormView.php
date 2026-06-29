<?php

namespace App\Http\Livewire\Reports\Views;

use Livewire\Component;
use App\Models\FiscalLimit;
use App\Models\AllotmentClass;
use App\Models\ServiceRegion;
use Illuminate\Support\Facades\DB;
class FiscalLimitFormView extends Component
{
    public $stage;
    public $year;
    public $fiscal_budget;




    public function render()
    {
        return view('livewire.reports.views.fiscal-limit-form-view');
    }
    public function mount()
    {
        $this->fiscal_budget = [];
        $this->categories =  AllotmentClass::with('fundChargeabilityClass.fundChargeability')->orderBy('created_at', 'desc')->get();
        $this->service_regions =  ServiceRegion::get();
        $this->getFiscalLimit();
        $this->getCategorySubTotal();
        $this->getServiceRegionTotal();
        $this->getCategoryTotal();
    }

    public function getFiscalLimit()
    {
        $this->fiscal_budget['entries'] = FiscalLimit::where('year', $this->year)
        ->where('stage_id',$this->stage)
        ->get();
    }
    public function getServiceRegionTotal()
    {
        $this->fiscal_budget['sr_total']  = FiscalLimit::select('serreg_id', DB::raw('SUM(amount) total'))
        ->where('year', $this->year)
        ->where('stage_id',$this->stage)
        ->groupBy('serreg_id')
        ->get();
    }
    public function getCategoryTotal()
    {
        $this->fiscal_budget['cat_total']  = FiscalLimit::select('cat_id', DB::raw('SUM(amount) total'))
        ->where('year', $this->year)
        ->where('stage_id',$this->stage)
        ->groupBy('cat_id')
        ->get();

        $this->fiscal_budget['overall_total']= $this->fiscal_budget['cat_total']->sum('total');
    }
    public function getCategorySubTotal()
    {
        $this->fiscal_budget['co_subtotal']  = FiscalLimit::select('cat_id', DB::raw('SUM(amount) total'))
        ->where('year', $this->year)
        ->where('stage_id',$this->stage)
        ->whereRelation('serviceRegion', 'co', '1')
        ->groupBy('cat_id')
        ->get();

        $this->fiscal_budget['ro_subtotal']  = FiscalLimit::select('cat_id', DB::raw('SUM(amount) total'))
        ->where('year', $this->year)
        ->where('stage_id',$this->stage)
        ->whereRelation('serviceRegion', 'co', '0')
        ->groupBy('cat_id')
        ->get();

        $this->fiscal_budget['co_subtotal_sum'] = $this->fiscal_budget['co_subtotal']->sum('total');
        $this->fiscal_budget['ro_subtotal_sum'] = $this->fiscal_budget['ro_subtotal']->sum('total');

    }
    public function getOverAllTotal()
    {
        $this->fiscal_budget['overall_total']  = FiscalLimit::select(DB::raw('SUM(amount) total'))
        ->where('year', $this->year)
        ->where('stage_id',$this->stage)
        ->get();
    }


}
