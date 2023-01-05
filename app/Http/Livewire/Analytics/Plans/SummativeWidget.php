<?php

namespace App\Http\Livewire\Analytics\Plans;

use Livewire\Component;
use App\Models\FormPoe;
use App\Models\PriorityClass;
use App\Models\KdpKpKs;
use App\Models\PapTag;
use App\Models\ThematicAreasCluster;
use Illuminate\Support\Facades\DB;

class SummativeWidget extends Component
{

    public $co_summary;
    public $ro_summary;
    public $pclass_summary;
    public $tagging_summary;
    public $sector_summary;
    public $kdpkpks_summary;
    public $pap_tags;
    public $thematic_area_clusters;




    public function render()
    {
        return view('livewire.analytics.plans.summative-widget');
    }
    public function offices()
    {
   
        $ro_lists =  FormPoe::where('status_id','2')
        ->whereRelation('ppmp', 'funded', '=', '1')
        ->whereRelation('ppmp', 'status_id', '=', '2')
        ->whereRelation('serviceRegion', 'office_id', '=', '1');

        $co_lists =  FormPoe::where('status_id','2')
        ->whereRelation('ppmp', 'funded', '=', '1')
        ->whereRelation('ppmp', 'status_id', '=', '2')
        ->whereRelation('serviceRegion', 'office_id', '=', '2');




      
        $this->ro_summary = [
            "num_paps"=> $ro_lists->count(),
            "total_budget"=> $ro_lists->sum('total'),
        ];
        $this->co_summary = [
            "num_paps"=> $co_lists->count(),
            "total_budget"=> $co_lists->sum('total'),
        ];

        // dd($this->co_summary);
    }
    public function priorityClass()
    {
        $this->pclass_summary = FormPoe::select('priority_classes.class', DB::raw("count(form_poes.id) as num_paps"), DB::raw("SUM(form_poes.total) as total_budget"))
        ->join('mfos','mfos.id', 'form_poes.mfo_id')
        ->join('priority_classes', 'priority_classes.id', 'mfos.pc_id')
        ->join('form_ppmps', 'form_ppmps.poe_id', 'form_poes.id')
        ->where('form_poes.status_id','2')
        ->where('form_ppmps.status_id','2')
        ->where('form_ppmps.funded','1')
        ->groupBy('mfos.pc_id')
        ->get();


        // dd(response()->json($this->pclass_summary));

    }
    public function poeTags()
    {
        // $this->tagging_summary = FormPoe::select('pap_tags.tag', DB::raw("count(form_poes.id) as num_paps"), DB::raw("SUM(form_poes.total) as total_budget"))
        // ->join('form_poe_tags','form_poe_tags.poe_id', 'form_poes.id')
        // ->join('pap_tags', 'pap_tags.id', 'form_poe_tags.paptag_id')
        // ->join('form_ppmps', 'form_ppmps.poe_id', 'form_poes.id')
        // ->where('form_poes.status_id','2')
        // ->where('form_ppmps.status_id','2')
        // ->where('form_ppmps.funded','1')
        // ->groupBy('form_poe_tags.paptag_id')
        // ->get();

        $this->pap_tags = PapTag::withSum(['poe' => function($query) {
            $query->whereHas('ppmp', function($q){
                $q->where('funded', '1');
                $q->where('status_id', '2');
            })->where('year', date('Y'));
        }], 'total')
        ->withCount(['poe' => function($query) {
            $query->whereHas('ppmp', function($q){
                $q->where('funded', '1');
                $q->where('status_id', '2');
            })->where('year', date('Y'));
        }])
        ->get();

    }
    public function targetSector()
    {
        $this->sector_summary = FormPoe::select('target_sectors.sector', DB::raw("count(form_poes.id) as num_paps"), DB::raw("SUM(form_poes.total) as total_budget"))
        ->join('form_poe_target_sectors','form_poe_target_sectors.poe_id', 'form_poes.id')
        ->join('target_sectors', 'target_sectors.id', 'form_poe_target_sectors.target_sector_id')
        ->join('form_ppmps', 'form_ppmps.poe_id', 'form_poes.id')
        ->where('form_poes.status_id','2')
        ->where('form_ppmps.status_id','2')
        ->where('form_ppmps.funded','1')
        ->groupBy('form_poe_target_sectors.target_sector_id')
        ->orderBy('total_budget', 'desc')
        ->get();
    }
    public function perkdpkpks()
    {
        $this->kdpkpks_summary = KdpKpKs::join('form_poes','form_poes.key_id', 'kdp_kp_ks.id')
        ->join('form_ppmps','form_poes.id', 'form_ppmps.poe_id')
        ->where('form_ppmps.funded','1')
        ->select(
            'kdp_kp_ks.id',
            'kdp_kp_ks.desc',
            DB::raw('SUM(form_poes.total) as total_budget'),
            DB::raw('count(form_poes.id) as num_paps')
        )
        ->groupBy('form_poes.key_id')
        ->orderBy('total_budget','desc')
        ->get();
    }

    public function thematic()
    {
        $this->thematic_area_clusters = ThematicAreasCluster::withSum(['allPoes' => function($query) {
            $query->whereHas('ppmp', function($q){
                $q->where('funded', '1');
                $q->where('status_id', '2');
            })->where('year', date('Y'));
        }], 'total')
        ->withCount(['allPoes' => function($query) {
            $query->whereHas('ppmp', function($q){
                $q->where('funded', '1');
                $q->where('status_id', '2');
            })->where('year', date('Y'));
        }])
        ->get();
    }



    public function mount()
    {
        $this->offices();
        $this->priorityClass();
        $this->poeTags();
        $this->targetSector();
        $this->perkdpkpks();
        $this->thematic();
    }
}
