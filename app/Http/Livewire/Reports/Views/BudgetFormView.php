<?php

namespace App\Http\Livewire\Reports\Views;

use Livewire\Component;
use App\Models\FormPoe;
class BudgetFormView extends Component
{
    public $year;
    public $serreg_id;
    public $pap_tags;
    public $stage_id;
    public $funded_status;
    public $funded_chargeability;

    public $reports;


    public function render()
    {
        return view('livewire.reports.views.budget-form-view');
    }

    public function mount()
    {
        $budget = FormPoe::join('form_ppmps','form_ppmps.poe_id', 'form_poes.id')
        ->with(
            'serviceRegion',
            'categoryClass.fundChargeability',
            'serviceRegion',
            'suggestedPap',
            'targetSectors',
            'mfo',
            'kdp',
            'thematicAreaCluster',
            'poeTags.papTag',
            'subpap.quarterTarget',
            'subpap.itemRequirements.suggestedItemRequirement',
            'subpap.itemRequirements.chartOfAccount',
            'subpap.itemRequirements.itemMonths',
            'subpap.itemRequirements.itemMonthSum',
        )
        ->where('form_poes.status_id', 2)
        ->where('form_poes.stage_id', 2)
        ->where('form_ppmps.status_id', 2)
        ->where('form_poes.service_region_id', strval($this->serreg_id))
        ->where('form_ppmps.funded', strval($this->funded_status))
        ->where('year', $this->year)
        ->select(
            "form_poes.id",
            "form_poes.suggested_pap_id",
            "form_poes.creator_id",
            "form_poes.pap_txt",
            "form_poes.geolocation",
            "form_poes.status_id",
            "form_poes.mfo_id",
            "form_poes.key_id",
            "form_poes.service_region_id",
            "form_poes.category_id",
            "form_poes.locker_user_id",
            "form_poes.thematic_area_cluster_id",
            "form_poes.stage_id",
            "form_poes.total",
            "form_poes.datetime_locked",
            "form_poes.locked",
            "form_ppmps.funded",

        )
        ->get()
        ->keyBy( function($files){
            $keys = $files->categoryClass->fundChargeability->type.'-'.$files->id;
            return $keys;
        });
  
    
        $reports = array();
        $keys = $budget->keys();
        foreach ($keys as $key) {
            $fund_chargeability = explode("-",  $key)[0];
            if (!array_key_exists($fund_chargeability, $reports)){
                $reports[$fund_chargeability] = [];
            }
            array_push($reports[$fund_chargeability], $budget[$key]);
        }
        $this->reports = $reports;
        $this->funded_chargeability = array_keys($reports);
    }
}
