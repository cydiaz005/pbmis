<?php

namespace App\Http\Livewire\Reports\Views;

use Livewire\Component;
use App\Models\PapTag;
use App\Models\FormPoe;
use App\Models\FundChargeability;
use App\Models\FormPpmp;


class ApbFormView extends Component
{

    public $year;
    public $serreg_id;
    public $stage_id;
    public $funded_status;
    public $pap_tags;
    public $reports;
    public $budget;

    public function render()
    {
        return view('livewire.reports.views.apb-form-view');
    }

    public function mount()
    {
        $this->pap_tags = PapTag::all();
        $budget = FormPoe::join('form_ppmps', 'form_ppmps.poe_id', 'form_poes.id')
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
            ->whereYear('form_ppmps.created_at', strval($this->year))
            ->where('form_poes.stage_id', strval($this->stage_id))
            ->where('form_poes.status_id', 2)
            ->where('form_ppmps.status_id', 2)
            ->where('form_ppmps.funded', '1')
            ->where('form_poes.service_region_id', strval($this->serreg_id))
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
            ->keyBy(function ($files) {
                $keys = $files->categoryClass->fundChargeability->type . '-' . $files->id;
                return $keys;
            });

        $reports = array();
        $keys = $budget->keys();
        foreach ($keys as $key) {
            $fund_chargeability = explode("-",  $key)[0];
            if (!array_key_exists($fund_chargeability, $reports)) {
                $reports[$fund_chargeability] = [];
            }
            array_push($reports[$fund_chargeability], $budget[$key]);
        }
        $this->reports = $reports;
        $this->funded_chargeability = array_keys($reports);
    }

    public function _mount()
    {
        $this->pap_tags = PapTag::all();

        $stage_id = strval($this->stage_id);
        $year = strval($this->year);
        $service_region_id = strval($this->serreg_id);
        $fc = FundChargeability::all()->keyBy('id');

        $formPpmp = FormPpmp::query();
        $formPpmp = $formPpmp->where('funded', '1')
            ->whereYear('created_at', $year)
            ->with([
                'poe',
                'poe.suggestedPap',
                'poe.subpap.suggestedSubPap',
                'poe.subpap.quarterTarget',
                'poe.subpap.itemRequirements.suggestedItemRequirement',
                'poe.subpap.itemRequirements.chartOfAccount',
                'poe.subpap.itemRequirements.itemMonths',
                'poe.creator.division_section',
                'poe.serviceRegion',
                'poe.categoryClass.fundChargeability',
                'poe.poeTags.papTag'
            ])
            ->whereHas('poe', function ($q) use ($stage_id, $service_region_id) {
                $q->where('stage_id', $stage_id)
                    ->where('service_region_id', $service_region_id);
            })->get()

            ->keyBy(function ($files) {
                $keys = $files->categoryClass->fundChargeability->type . '-' . $files->id;
                return $keys;
            });

        $formPpmp = $formPpmp->groupBy('poe.categoryClass.fundChargeability.id');

        $this->reports = $formPpmp;
        $this->funded_chargeability = $fc;
    }
}

