<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FormPoe;
use App\Models\KdpKpKs;
use App\Models\PriorityClass;
use App\Models\TargetSector;
use App\Models\FormPoeTargetSector;
use App\Models\PapTag;
use App\Models\ThematicAreasCluster;
use App\Models\ServiceRegion;
use App\Models\Stage;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */

    public function redirect()
    {
        $roles = Role::all();
        $subscribed_roles = Auth::user()->getRoleNames();
        $status = Auth::user()->status;

        if($status==0){
            return $this->pendingApproval();
        }
        else if ($status==2){
            return $this->pendingApproval();
        }
   
        switch ($subscribed_roles[0]) {
            case "Super Administrator":
                return $this->superAdmin();
                break;
            case "Administrator":
                return $this->admin();
                break;
            case "Technical Working Group":
                return $this->twg();
                break;
            case "Planning Focal/Officer":
                return $this->pfo();
                break;
            case "Encoder":
                return $this->pfo();
                break;
            case "Plans Administrator":
                return $this->plansAdministrator();
                break;
            case "Budget Administrator":
                return $this->budgetAdministrator();
                break;
            case "Procurement Administrator":
                return $this->procurementAdministrator();
                break;
            case "Guest":
                return $this->pendingApproval();
                break;
            case "Banned":
                return $this->pendingApproval();
                break;
            case "Developer":
                return $this->superAdmin();
                break;
            default:
                abort(404);
          }

    }
    
    public function superAdmin()
    {
        return (Auth::user()->hasPermissionTo('dashboard-super-admin-access'))?  view('pages.dashboard.super-admin'):abort(403);
    }

    public function admin()
    {
        return (Auth::user()->hasPermissionTo('dashboard-admin-access'))?  view('pages.dashboard.admin'):abort(403);
    }

    public function plansAdministrator()
    {
        return (Auth::user()->hasPermissionTo('dashboard-plans-access'))?  view('pages.dashboard.plans'):abort(403);
    }

    public function budgetAdministrator()
    {
        return (Auth::user()->hasPermissionTo('dashboard-budget-access'))?  view('pages.dashboard.admin'):abort(403);
    }

    public function procurementAdministrator()
    {
        return (Auth::user()->hasPermissionTo('dashboard-procurement-access'))?  view('pages.dashboard.procurement'):abort(403);
    }
    public function twg()
    {
        $data = [
            'poe'=>$data = DB::table('form_poes')->selectRaw('COUNT(CASE WHEN status_id = 1 THEN 1 END) as draft, COUNT(CASE WHEN status_id = 2 THEN 1 END) as published, COUNT(CASE WHEN status_id = 4 THEN 1 END) as returned, COUNT(CASE WHEN status_id = 5 THEN 1 END) as resolved')->first(),
            'ppmp'=>$data = DB::table('form_ppmps')
                ->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
                ->selectRaw('COUNT(CASE WHEN form_ppmps.status_id = 3 THEN 1 END) as for_review, COUNT(CASE WHEN form_ppmps.status_id = 2 THEN 1 END) as published, COUNT(CASE WHEN form_ppmps.status_id = 4 THEN 1 END) as returned, COUNT(CASE WHEN form_ppmps.status_id = 5 THEN 1 END) as resolved')
                ->first()
        ];
        // return $data;
        return (Auth::user()->hasPermissionTo('dashboard-twg-access'))?  view('pages.dashboard.twg', $data):abort(403);
    }

    public function pfo()
    {
        $data = DB::table('form_poes')->where('service_region_id', Auth::user()->serreg_id)->selectRaw('COUNT(CASE WHEN status_id = 1 THEN 1 END) as draft, COUNT(CASE WHEN status_id = 2 THEN 1 END) as published, COUNT(CASE WHEN status_id = 4 THEN 1 END) as returned, COUNT(CASE WHEN status_id = 5 THEN 1 END) as resolved')->first();
        return (Auth::user()->hasPermissionTo('dashboard-fp-o-access'))?  view('pages.dashboard.pf-o', ['data'=>$data]):abort(403);
    }

    public function plans()
    {
        

        // $target_sector = FormPoe::select('target_sectors.sector', DB::raw("count(form_poes.id) as num_paps"), DB::raw("SUM(form_poes.total) as total_budget"))
        // ->join('form_poe_target_sectors','form_poe_target_sectors.poe_id', 'form_poes.id')
        // ->join('target_sectors', 'target_sectors.id', 'form_poe_target_sectors.target_sector_id')
        // ->join('form_ppmps', 'form_ppmps.poe_id', 'form_poes.id')
        // ->where('form_poes.status_id','2')
        // ->where('form_ppmps.status_id','2')
        // ->where('form_ppmps.funded','1')
        // ->groupBy('form_poe_target_sectors.target_sector_id')
        // ->get();
        // return response()->json($target_sector);
        return (Auth::user()->hasPermissionTo('dashboard-plans-access'))?  view('pages.dashboard.plans'):abort(403);
    }

    public function budget()
    {
        return (Auth::user()->hasPermissionTo('dashboard-budget-access'))?  view('pages.dashboard.admin'):abort(403);
    }

    public function procurement()
    {
        return (Auth::user()->hasPermissionTo('dashboard-procurement-access'))?  view('pages.dashboard.procurement'):abort(403);
    }

    public function pendingApproval()
    {
        $boarded = (Auth::user()->firstname) && (Auth::user()->lastname) && (Auth::user()->pos_id) && (Auth::user()->divsec_id) && (Auth::user()->serreg_id);
        if (!$boarded) {
            return (Auth::user()->hasPermissionTo('general'))?  view('onboarding1'):abort(403);
        }
        else{
            return (Auth::user()->hasPermissionTo('general'))?  view('onboarding5'):abort(403);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */

    public function plansWidgetKeys()
    {

        $widget_kdkpks = KdpKpKs::join('form_poes','form_poes.key_id', 'kdp_kp_ks.id')
        ->join('form_ppmps','form_poes.id', 'form_ppmps.poe_id')
        ->where('form_ppmps.funded','1')
        ->select(
            'kdp_kp_ks.id',
            'kdp_kp_ks.desc as kdpkpks',
            DB::raw('SUM(form_poes.total) as total_budget'),
            DB::raw('count(form_poes.id) as funded_paps')
        )
        ->groupBy('form_poes.key_id')
        ->orderBy('kdp_kp_ks.id')
        ->get();
        
        return response()->json($widget_kdkpks);
    }

    public function plansListOfPapsPerOffice()
    {
        // $ServiceRegion = $this->directRelationshipFormatter("App\Models\ServiceRegion", "accronym");
        // return response()->json($ServiceRegion);    
        return view('pages.dashboard.listofpaps.per-office', ['service_regions'=>ServiceRegion::all()]);
    }
    public function plansListOfPapsPerpriorityClass()
    {   
        return view('pages.dashboard.listofpaps.per-priority-class', ['priority_classes'=>PriorityClass::all()]);
    }
    public function plansListOfPapsPerkdpkpks()
    {
        return view('pages.dashboard.listofpaps.per-kdp-kp-ks', ['kdpkpks'=>KdpKpKs::all()]);
    }

    public function plansListOfPapsPerpaptag()
    {
        return view('pages.dashboard.listofpaps.per-pap-tag', ['paptags'=>PapTag::all()]);
    }

    public function plansListOfPapsPertargetSector()
    {
        // $test = FormPoe::join('form_ppmps', 'form_ppmps.poe_id','form_poes.id')
        // ->join('form_poe_sub_paps','form_poe_sub_paps.poe_id','form_poes.id')
        // ->get();
        // return response()->json($test);
        return view('pages.dashboard.listofpaps.per-target-sector', ['target_sectors'=>TargetSector::all()]);
    }
    
    public function plansListOfPapsPerthematicAreaClusters()
    {
        // $thematicAreasCluster = $this->directRelationshipFormatter("App\Models\ThematicAreasCluster", "thematic_area_cluster");
        // return response()->json($thematicAreasCluster);
        return view('pages.dashboard.listofpaps.per-thematic-areas-cluster', ['thematic_areas_clusters'=>ThematicAreasCluster::all()]);
    }


    public function directRelationshipFormatter($model, $groupByAttribute)
    {
        $stage_id = Stage::where('active','1')->first()->id;
        $collections= $model::with([
            "poes.mfo.priorityClass",
            "poes.suggestedPap",
            "poes.poeTags.papTag",    
            "poes.subpap.quarterTarget",    
            "poes.subpap.suggestedSubPap",
            "poes.subpap.itemRequirements",
            "poes.subpap.itemRequirements.suggestedItemRequirement",
            "poes.subpap.itemRequirements.itemMonths",
            "poes.subpap.itemRequirements.itemMonthSum",
            "poes.categoryClass.fundChargeability",
            "poes" => function($query) use($stage_id){
                $query->where('status_id', '=', '2')
                ->where('stage_id', '=', $stage_id)
                ->whereYear('created_at', '=', '2022');
            }  
        ])
        ->whereRelation('poes.ppmp', 'funded', '=', '1')
        ->whereRelation('poes.ppmp', 'status_id', '=', '2')
        // ->where('service_regions.id', 2) // Selected Regions
        ->get();

        return $collections;

        // return $collections;    
      
        $lists = [];
        foreach ($collections as $collection) {
             // Segregating PAPs
            (count($collection->poes))? $lists[$collection[$groupByAttribute]] = $collection->poes:false;
        }

        return $lists;    
    }

}
