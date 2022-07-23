<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\DivisionSection;
use App\Models\Position;
use App\Models\ServiceRegion;
use App\Models\FundChargeability;
use App\Models\TargetSector;
use App\Models\ProcurementMode;
use App\Models\AllotmentClass;
use App\Models\ChartOfAccounts;
use App\Models\Category;
use App\Models\PapTag;
use App\Models\ListOfPap;
use App\Models\ListOfSubPap;
use App\Models\ListOfItemRequirement;
use App\Models\Mfo;
use App\Models\KdpKpKs;
use App\Models\PriorityClass;
use App\Models\FundChargeabilityClass;
use App\Models\FundChargeabilityClassAccount;
use App\Models\KdpkpksMfoCategory;
use App\Models\Stage;
use App\Models\PerformanceMeasures;
use App\Models\Office;
use App\Http\Controllers\EmailController;
use App\Actions\Notify\Notify;
use App\Models\User;
class FieldDependencyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */

    public function divisionSection(){
        return (Auth::user()->hasPermissionTo('division-section-access'))?  view('pages.extras.division-section'):abort(403);
    }

    public function position(){
        return (Auth::user()->hasPermissionTo('position-access'))?  view('pages.extras.position'):abort(403);
    }

    public function serviceRegion(){
        return (Auth::user()->hasPermissionTo('service-region-access'))?  view('pages.extras.service-region'):abort(403);
    }

    public function targetSector(){
        return (Auth::user()->hasPermissionTo('target-sectors-access'))?  view('pages.extras.target-sector'):abort(403);
    }
    
    public function procurementMode(){
        return (Auth::user()->hasPermissionTo('procurement-mode-access'))?  view('pages.extras.procurement-mode'):abort(403);
    }
    public function designateCoa(){
        return (Auth::user()->hasPermissionTo('categorized-accounts-acces'))?  view('pages.extras.designate-coa'):abort(403);
    }

    public function allotmentClass(){
        return (Auth::user()->hasPermissionTo('allotment-class-access'))?  view('pages.extras.allotment-class'):abort(403);
    }

    public function fundChargeability (){
        return (Auth::user()->hasPermissionTo('fund-chargeability-access'))?  view('pages.extras.fund-chargeability'):abort(403);
    }

    public function chartOfAccounts(){
        return (Auth::user()->hasPermissionTo('chart-of-accounts-access'))?  view('pages.extras.chart-of-accounts'):abort(403);
    }

    public function categorizedAccount(){
        return (Auth::user()->hasPermissionTo('categorized-accounts-access'))?  view('pages.extras.categorized-account'):abort(403);
    }

    public function papTags(){
        return (Auth::user()->hasPermissionTo('pap-tagging-access'))?  view('pages.extras.pap-tags'):abort(403);
    }

    public function suggestedPap(){
        return (Auth::user()->hasPermissionTo('default-paps-access'))?  view('pages.extras.suggested-pap'):abort(403);
    }

    public function suggestedSubPap(){
        return (Auth::user()->hasPermissionTo('default-sub-paps-access'))?  view('pages.extras.suggested-sub-pap'):abort(403);
    }

    public function itemRequirement(){
        return (Auth::user()->hasPermissionTo('default-item-requirement-access'))?  view('pages.extras.suggested-item-req'):abort(403);
    }

    public function priorityClass(){
        return (Auth::user()->hasPermissionTo('priority-class-access'))?  view('pages.extras.priority-class'):abort(403);
    }

    public function mfo(){
        return (Auth::user()->hasPermissionTo('mfo-access'))?  view('pages.extras.mfo'):abort(403);
    }

    public function kdpkdks(){
        return (Auth::user()->hasPermissionTo('kdpkdks-access'))?  view('pages.extras.kdpkdks'):abort(403);
    }
    public function stages(){
        return (Auth::user()->hasPermissionTo('kdpkdks-access'))?  view('pages.extras.stages'):abort(403);
    }
    public function performanceMeasures(){
        //TODO PERMISSION
        return (Auth::user()->hasPermissionTo('report-opc-access'))?  view('pages.extras.performance-measures'):abort(403);
    }
    public function officePerMfo(){
        //TODO PERMISSION
        return (Auth::user()->hasPermissionTo('report-opc-access'))?  view('pages.extras.office-mfo'):abort(403);
    }
    public function editOfficePerMfo($id){
        return (Auth::user()->hasPermissionTo('report-opc-access'))?  view('pages.office-mfo-edit',['id'=>$id]):abort(403);    

    }

    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */

    public function storeDivisionSection(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        
      $division =   DivisionSection::create([
            'name' => $request->name,
            'accronym' => $request->accronym,
        ]);
        $recieverIds = [];
        $recieverEmail = [];
        $users = User::where('id', "!=", Auth::user()->id)
                        ->where("status", '1')
                        ->get();
                       
        foreach ($users as $value) {
            array_push( $recieverIds, $value->id);
            array_push( $recieverEmail, $value->email);
        }
        Notify::create( $recieverIds,
            [
                "type" => "user-create-divisionSection",
                "notifiable" => ['App\Models\DivisionSection',@$division->id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "Created Division Section <strong>".$request->name."</strong>",
            ]
        );

      return back()->with('success', 'Division/Section created successfully');
      
      
    }
    public function deleteDivisionSection($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        DivisionSection::destroy($id);
        $recieverIds = [];
        $recieverEmail = [];
        $users = User::where('id', "!=", Auth::user()->id)
                        ->where("status", '1')
                        ->get();
        foreach ($users as $value) {
            array_push( $recieverIds, $value->id);
            array_push( $recieverEmail, $value->email);
        }
        Notify::create( $recieverIds,
            [
                "type" => "user-delete-divisionSection",
                "notifiable" => ['App\Models\DivisionSection',@$id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "Deleted Division Section",
            ]
            
        );
        return back()->with('success', 'Division/Section deleted successfully');
    }

    public function storePosition(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
      $pos =   Position::create([
            'job_title' => $request->job_title,
        ]);
        $recieverIds = [];
        $recieverEmail = [];
        $users = User::where('id', "!=", Auth::user()->id)
        ->where("status", '1')
                    ->get();
            foreach ($users as $value) {
            array_push( $recieverIds, $value->id);
            array_push( $recieverEmail, $value->email);
            }
            Notify::create( $recieverIds,
            [
                "type" => "user-create-position",
                "sender" => ['App\Models\User', Auth::user()->id],
                "notifiable" => ['App\Models\Position',@$pos->id],
                "message" => "Created Position <strong>".$request->job_title."</strong>",
            ]

            );
        return back()->with('success', 'Position created successfully');

    }
    public function deletePosition($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        Position::destroy($id);
        $recieverIds = [];
        $recieverEmail = [];
        $users = User::where('id', "!=", Auth::user()->id)
                        ->where("status", '1')
                        ->get();
        foreach ($users as $value) {
            array_push( $recieverIds, $value->id);
            array_push( $recieverEmail, $value->email);
        }
        Notify::create($recieverIds,
            [
                "type" => "user-delete-position",
                "sender" => ['App\Models\User', Auth::user()->id],
                "notifiable" => ['App\Models\Position',@$id],
                "message" => "Deleted Position Section",
            ]
            
        );
        return back()->with('success', 'Position deleted successfully');
    }

    public function storeServiceRegion(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
      $service =  ServiceRegion::create([
            'service_region' => $request->service_region,
            'accronym' => $request->accronym,
        ]);
        $recieverIds = [];
        $recieverEmail = [];
        $users = User::where('id', "!=", Auth::user()->id)
        ->where("status", '1')
                    ->get();
            foreach ($users as $value) {
            array_push( $recieverIds, $value->id);
            array_push( $recieverEmail, $value->email);
            }
            Notify::create( $recieverIds,
            [
            "type" => "user-create-serviceRegion",
            "sender" => ['App\Models\User', Auth::user()->id],
            "notifiable" => ['App\Models\ServiceRegion',@$service->id],
            "message" => "Created New Service Region <strong>".$request->service_region."</strong>",
            ]

            );
        return back()->with('success', 'Service/Region created successfully');

    }
    public function deleteServiceRegion($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ServiceRegion::destroy($id);
        $recieverIds = [];
        $recieverEmail = [];
        $users = User::where('id', "!=", Auth::user()->id)
                        ->where("status", '1')
                        ->get();
        foreach ($users as $value) {
            array_push( $recieverIds, $value->id);
            array_push( $recieverEmail, $value->email);
        }
        Notify::create($recieverIds,
            [
                "type" => "user-delete-serviceRegion",
                "sender" => ['App\Models\User', Auth::user()->id],
                "notifiable" => ['App\Models\ServiceRegion',@$id],
                "message" => "Deleted Service Region",
            ]
            
        );
        return back()->with('success', 'Service/Region deleted successfully');
    }


    public function storeFundChargeability(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        FundChargeability::create([
            'code' => $request->code,
            'type' => $request->type,
            'accronym' => $request->accronym,
        ]);
        return back()->with('success', 'Fund Chargeability created successfully');

    }
    public function deleteFundChargeability($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        FundChargeability::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storePriorityClass(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        PriorityClass::create([
            'class' => $request->class,
            'accronym' => $request->accronym,
        ]);
        return back()->with('success', 'Priority Class created successfully');

    }
    public function deletePriorityClass($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        PriorityClass::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }


    public function storeTargetSector(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        TargetSector::create([
            'sector' => $request->sector,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteTargetSector($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        TargetSector::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeProcurementMode(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ProcurementMode::create([
            'section' => $request->section,
            'title' => $request->title,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteProcurementMode($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ProcurementMode::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeAllotmentClass(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        AllotmentClass::create([
            'code' => $request->code,
            'class' => $request->class,
            'accronym' => $request->accronym,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteAllotmentClass($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        AllotmentClass::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }


    public function storeChartOfAccounts(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ChartOfAccounts::create([
            'code' => $request->code,
            'expense_object' => $request->expense_object,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteChartOfAccounts($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ChartOfAccounts::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    //TODO
    public function storeCategorizedAccount(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}

        //check if item already exists and throw an error message
        $fund_charge_exists = FundChargeabilityClass::where('ac_id',$request->ac_id)->where('fc_id', $request->fc_id)->first();
        if($fund_charge_exists) return back()->with('error-allotment_class', 'Item already exists');

        FundChargeabilityClass::firstOrCreate([
            'ac_id' => $request->ac_id,
            'fc_id' =>$request->fc_id,
        ]);
        return back()->with('success-allotment_class', 'Item created successfully');

    }
    public function deleteCategorizedAccount($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        FundChargeabilityClass::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }
    public function storeCoaFccCategory(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}

        //check if item already exists and throw an error message
        $fund_charge_account_exists = FundChargeabilityClassAccount::where('coa_id',$request->coa_id)->where('fcc_id', $request->fcc_id)->first();
        if($fund_charge_account_exists) return back()->with('error-coa_fc', 'Item already exists');

        FundChargeabilityClassAccount::firstOrCreate([
            'coa_id' => $request->coa_id,
            'fcc_id' =>$request->fcc_id,
        ]);
        return back()->with('success-coa_fc', 'Item created successfully');

    }
    public function deleteCoaFccCategory($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        FundChargeabilityClassAccount::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeKdpkpksMfoCategory(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}

        //check if item already exists and throw an error message
        $kdp_kpks_mfo_category = KdpkpksMfoCategory::where('kdpkpks_id',$request->kdpkpks_id)->where('mfo_id', $request->mfo_id)->first();
        if($kdp_kpks_mfo_category) return back()->with('error-kmc', 'Item already exists');

        KdpkpksMfoCategory::firstOrCreate([
            'kdpkpks_id' => $request->kdpkpks_id,
            'mfo_id' =>$request->mfo_id,
        ]);
        return back()->with('success-kmc', 'Item created successfully');

    }
    public function deleteKdpkpksMfoCategory($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        KdpkpksMfoCategory::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    //END TODO


    public function storePapTags(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        PapTag::create([
            'tag' => $request->tag,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deletePapTags($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        PapTag::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeSuggestedPap(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ListOfPap::create([
            'paps' => $request->paps,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteSuggestedPap($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ListOfPap::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeSuggestedSubPap(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ListOfSubPap::create([
            'subpaps' => $request->subpaps,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteSuggestedSubPap($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ListOfSubPap::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeItemRequirement(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ListOfItemRequirement::create([
            'ireq' => $request->ireq,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteItemRequirement($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        ListOfItemRequirement::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeMfo(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        Mfo::create([
            'pc_id' => $request->pc_id,
            'desc' => $request->desc,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteMfo($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        $mfo = Mfo::find($id);
        Mfo::destroy($id);
        $mfos_to_decrement = Mfo::where([['order','>',$mfo->order]])->get();
        foreach ($mfos_to_decrement as $key => $mfo_to_d) {
            if($mfo_to_d->order==$mfo->order){
                $mfo->order = $order;
            }
            $mfo_to_d->decrement('order');
        }
        return back()->with('success', 'Item deleted successfully');
    }

    public function changeMfoOrder(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        $request->validate([
            'order' => 'required',
        ]);
        $mfo = Mfo::find($id);
        $order = (int)$request->order;
        if($order==$mfo->order)
        {
            return response()->json("Mfo Updated");
        }

        // 1 - hello
        // 2 - hello2
        // 3 - hello3
        // 4 - hello4
        // 5 - hello5



        // change hello3 to 2
        // 1 - hello
        // 2 - hello3
        // 3 - hello2
        // 4 - hello4
        // 5 - hello5

        //increment an number kun hain hya igbubutang

            $mfos_to_increment = Mfo::where([['order','>=',$order],['order','<=',$mfo->order]])->get();
            foreach ($mfos_to_increment as $key => $mfo_to_i) {
                if($mfo_to_i->order==$mfo->order){
                    $mfo->order = $order;
                }
                $mfo_to_i->increment('order');
            }
            $mfos_to_decrement = Mfo::where([['order','<=',$order],['order','>=',$mfo->order]])->get();
            foreach ($mfos_to_decrement as $key => $mfo_to_d) {
                if($mfo_to_d->order==$mfo->order){
                    $mfo->order = $order;
                }
                $mfo_to_d->decrement('order');
            }
     
        $mfo->save();
        return response()->json("Mfo Updated");
    }

    public function storeKdpkdks(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        KdpKpKs::create([
            'desc' => $request->desc,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteKdpkdks($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        KdpKpKs::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function storeStage(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        Stage::create([
            'name' => $request->name,
            'accronym' => $request->accronym,
            'active' => $request->active,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deleteStage($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        Stage::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }

    public function changeStageStatus(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        $request->validate([
            'active' => 'required',
        ]);
        $active = $request->active;
        $stage = Stage::find($id);
        $stage->active = $active;
        $stage->save();
        return response()->json("Stage Status Updated");
    }

    public function storePerformanceMeasures(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        PerformanceMeasures::create([
            'name' => $request->name,
            'legend' => $request->legend,
        ]);
        return back()->with('success', 'Item created successfully');

    }
    public function deletePerformanceMeasures($id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        PerformanceMeasures::destroy($id);
        return back()->with('success', 'Item deleted successfully');
    }


    public function updateOfficeMfos(Request $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('field-dependency-access')){abort(403);}
        $request->validate([
            'mfosToToggle' => 'required',
        ]);
        $office = Office::find($id);
        $mfosToToggle = $request->mfosToToggle;
        $office->mfos()->toggle($mfosToToggle);
        return response()->json($office->mfos);
    }
    
}
