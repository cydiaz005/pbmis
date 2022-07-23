<?php

namespace App\Http\Controllers;

use App\Models\FormOpc;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\FundChargeabilityClass;
use App\Models\FundChargeabilityClassAccount;
use App\Models\TargetSector;
use App\Models\ListOfSubPap;
use App\Models\ListOfPap;
use App\Models\PapTag;
use App\Models\Units;
use App\Models\Mfo;
use App\Models\MfoKey;
use App\Models\KdpKpKs;
use App\Models\ServiceRegion;
use App\Models\ProcurementMode;
use App\Models\ListOfItemRequirement;
use App\Models\FormPoeItemRequirementMonth;
use App\Models\FormPoeTargetSector;
use App\Models\FormPoe;
use App\Models\FormPpmp;
use App\Models\FormPoeItemRequirement;
use App\Models\FormPoeSubPap;
use App\Models\FormPoeTag;
use App\Models\ThematicAreasCluster;
use App\Models\QuarterTarget;
use App\Models\ReturnedForm;
use App\Models\Setting;
use App\Models\Stage;
use Carbon\Carbon;
use App\Models\Notification;
use Auth;
use Crypt;
use Error;

use App\Models\User;
use App\Http\Controllers\EmailController;
use App\Actions\Notify\Notify;
use App\Models\FundChargeability;
use Illuminate\Support\Facades\DB;

class PoeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */

    public function poeReport()
    {
        return view('pages/reports/poe');
    }

    public function ppmpReport()
    {
        return view('pages/reports/ppmp');
    }

    public function classify()
    {
        $due_date = Setting::where('key', 'classification_end_date')->first();
        $due = true;
        if (@$due_date) {
            $due = Carbon::parse($due_date->value)->lt(Carbon::now());
        }
        return (Auth::user()->hasPermissionTo('form-ppmp-classification-access')) ?  view('pages/form/ppmpclassify', [
            "end_date" => $due_date,
            "due" => $due,
            "lock_all" => (!Auth::user()->hasPermissionTo("form-ppmp-classification-all-access") && $due),
        ]) : abort(403);
    }

    public function budgetFundedReport()
    {
        return view('pages/reports/budget-funded');
    }

    public function budgetUnfundedReport()
    {
        return view('pages/reports/budget-unfunded');
    }
    public function apbReport()
    {
        return view('pages/reports/apb');
    }

    public function getReport($year, $origin)
    {
        $service_region = ServiceRegion::find($origin);

        return view('pages/reports/budget-funded-view', [
            'year' => $year,
            'service_region' => $service_region,
            'funded_status' => 1
        ]);
    }

    public function getFundedReport($year, $origin)
    {
        $service_region = ServiceRegion::find($origin);

        return view('pages/reports/budget-funded-view', [
            'year' => $year,
            'service_region' => $service_region,
            'funded_status' => 1
        ]);
    }

    public function getUnfundedReport($year, $origin)
    {
        $service_region = ServiceRegion::find($origin);
        return view('pages/reports/budget-unfunded-view', [
            'year' => $year,
            'service_region' => $service_region,
            'funded_status' => 0
        ]);
    }



    public function viewFundedReport($stage, $year, $origin)
    {
        $service_region = ServiceRegion::find($origin);

        return view('pages/reports/budget-funded-view', [
            'year' => $year,
            'stage' => $stage,
            'service_region' => $service_region,
            'funded_status' => 1
        ]);
    }

    public function viewUnfundedReport($stage, $year, $origin)
    {
        $service_region = ServiceRegion::find($origin);
        return view('pages/reports/budget-unfunded-view', [
            'year' => $year,
            'stage' => $stage,
            'service_region' => $service_region,
            'funded_status' => 0
        ]);
    }
    public function getBudgetReportData(Request $request)
    {
        $stage_id = $request->stage_id;
        $year = $request->year;
        $service_region_id = $request->service_region_id;
        $funded_status = $request->funded_status;
        $fc = FundChargeability::all()->keyBy('id');

        $formPpmp = FormPpmp::query();
        $formPpmp = $formPpmp->where('funded', $funded_status)
            ->whereYear('created_at', $year)
            ->with([
                'poe',
                'poe.suggestedPap',
                'poe.subpap.suggestedSubPap',
                'poe.subpap.itemRequirements.suggestedItemRequirement',
                'poe.subpap.itemRequirements.chartOfAccount',
                'poe.subpap.itemRequirements.procurementMode',
                'poe.subpap.itemRequirements.appForm',
                'poe.subpap.itemRequirements.itemMonths',
                'poe.creator.division_section',
                'poe.serviceRegion',
                'poe.categoryClass.fundChargeability',
            ])
            ->whereHas('poe', function ($q) use ($stage_id, $service_region_id) {
                $q->where('stage_id', $stage_id)
                    ->where('service_region_id', $service_region_id);
            })->get()->groupBy('poe.categoryClass.fundChargeability.id');

        return ['form_ppmp' => $formPpmp, 'fund_chargeability' => $fc];
    }



    public function viewApbReport($stage, $year, $origin)
    {

        $service_region = ServiceRegion::find($origin);
        return view('pages/reports/apb-view', [
            'year' => $year,
            'stage' => $stage,
            'service_region' => $service_region,
            'funded_status' => 0
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */


    public function encryptUrlParams(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('forms-access')) {
            abort(403);
        }
        if (!@$request->input('papname') || !@$request->input('mfo') || !@$request->input('kdp')) {
            abort(404);
        }
        $parameter = [
            "papname" => @$request->input('papname'),
            "mfo" => @$request->input('mfo'),
            "kdp" => @$request->input('kdp'),
        ];
        $encrypted_parameter = Crypt::encrypt($parameter);
        return redirect('form/poe/create/' . $encrypted_parameter);
    }

    public function formPoeCreate($parameter)
    {
        if (!Auth::user()->hasPermissionTo('forms-access')) {
            abort(403);
        }
        try {
            $decrypted_parameter = Crypt::decrypt($parameter);
            $kdp = KdpKpKs::where('id', (int)$decrypted_parameter['kdp'])->first();
            $mfo = Mfo::where('id', (int)$decrypted_parameter['mfo'])->first();
            $fc = FundChargeabilityClass::with(['allotmentClass', 'fundChargeability'])->get();
            $service_regions = ServiceRegion::all();
            $target_sectors = TargetSector::all();
            $pap_tags = PapTag::all();
            $procurement_modes = ProcurementMode::all();
            return view('pages.form.create-poe', [
                "papname" => $decrypted_parameter['papname'],
                "mfo_id" => $mfo->id,
                "mfo" => $mfo->desc,
                "kdp_id" => $kdp->id,
                "kdp" => $kdp->desc,
                "fc" => $fc,
                "service_regions" => $service_regions,
                "target_sectors" => $target_sectors,
                "procurement_modes" => $procurement_modes,
                "pap_tags" => $pap_tags,
                "thematicAreasClusters" => ThematicAreasCluster::all(),
                "quarterTargets" => QuarterTarget::all(),
            ]);
        } catch (DecryptException $e) {
            abort(404);
        }
    }

    public function formPoe()
    {
        if (!Auth::user()->hasPermissionTo('forms-access')) {
            abort(403);
        }
        $mfo = MfoKey::with('mfo')->get();
        return view('pages.form.poe', [
            "mfo" => $mfo,
        ]);
    }

    public function getKdp($id)
    {
        return MfoKey::where('mfo_id', $id)->with('kdp')->get();
    }

    public function save(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('forms-access')) {
            abort(403);
        }
        $formPoe = new FormPoe;
        $pap_id = ListOfPap::where('paps', $request->input('pap_name'))->pluck('id')->first();
        $formPoe->suggested_pap_id = (isset($pap_id)) ? $pap_id : null;
        $formPoe->creator_id = Auth::user()->id;
        $formPoe->pap_txt = (isset($pap_id)) ? null : $request->input('pap_name');
        $formPoe->geolocation = $request->input('geograpical_loc');
        $formPoe->status_id = 1;
        $formPoe->mfo_id = $request->input('mfo_id');
        $formPoe->key_id = $request->input('kdp_id');
        $formPoe->service_region_id = Auth::user()->serreg_id;
        $formPoe->category_id = $request->input('category_code_id');
        $formPoe->thematic_area_cluster_id = $request->input('thematic_area_cluster');
        $formPoe->total = $request->input('total');
        $formPoe->stage_id = Stage::where('active', '1')->first()->id;
        $formPoe->save();

        $target_sectors = $request->input('target_sector');
        foreach ($target_sectors as $target_sector) {
            $formPoeTargetSector = new FormPoeTargetSector;
            $formPoeTargetSector->poe_id = $formPoe->id;
            $formPoeTargetSector->target_sector_id = $target_sector;
            $formPoeTargetSector->save();
        }

        $poe_tags = $request->input('form_related');
        foreach ($poe_tags as $poe_tag) {
            $formPoeTag = new FormPoeTag;
            $formPoeTag->poe_id = $formPoe->id;
            $formPoeTag->paptag_id = $poe_tag;
            $formPoeTag->save();
        }

        $subpaps = $request->input('subpaps');
        foreach ($subpaps as $subpap) {
            $subpap_list_id = ListOfSubPap::where('subpaps', $subpap['sub_pap_name'])->pluck('id')->first();
            $formPoeSubPap = new FormPoeSubPap;
            $formPoeSubPap->poe_id = $formPoe->id;
            $formPoeSubPap->suggested_subpap_id = (isset($subpap_list_id)) ? $subpap_list_id : null;
            $formPoeSubPap->subpap_txt = (isset($subpap_list_id)) ? null : $subpap['sub_pap_name'];
            $formPoeSubPap->quarter_target_id = $subpap['subpap_quarter_target'];
            $formPoeSubPap->save();

            $item_reqs = $subpap['item_reqs'];

            foreach ($item_reqs as $item_req) {
                $item_req_list_id = ListOfItemRequirement::where('ireq', $item_req['item_requirement'])->pluck('id')->first();
                $item_unit_id = Units::where('unit', $item_req['item_unit'])->pluck('id')->first();
                $formPoeItemRequirement = new FormPoeItemRequirement;
                $formPoeItemRequirement->subpap_id = $formPoeSubPap->id;
                $formPoeItemRequirement->account_id = $item_req['item_account_code_id'];
                $formPoeItemRequirement->suggested_itemreq_id = (isset($item_req_list_id)) ? $item_req_list_id : null;
                $formPoeItemRequirement->itemreq_txt = (isset($item_req_list_id)) ? null : $item_req['item_requirement'];
                $formPoeItemRequirement->per_capita_cost = $item_req['item_cost'];
                $formPoeItemRequirement->unit_id = (isset($item_unit_id)) ? $item_unit_id : null;
                $formPoeItemRequirement->unit = (isset($item_unit_id)) ? null : $item_req['item_unit'];
                $formPoeItemRequirement->procurement_mode_id = $item_req['item_procurement_mode'];
                $formPoeItemRequirement->qty_pax = $item_req['item_qty_pax'];
                $formPoeItemRequirement->no_of_days = $item_req['item_days'];
                $formPoeItemRequirement->save();

                $item_req_months = $item_req['item_months'];

                foreach ($item_req_months as $item_req_month) {
                    $formPoeItemRequirementMonth = new FormPoeItemRequirementMonth;
                    $formPoeItemRequirementMonth->item_req_id = $formPoeItemRequirement->id;
                    $formPoeItemRequirementMonth->month = $item_req_month['month'];
                    $formPoeItemRequirementMonth->amount = $item_req_month['amount'];
                    $formPoeItemRequirementMonth->qty = $item_req_month['qty'];
                    $formPoeItemRequirementMonth->save();
                }
            }
        }

        // return $formPoe;
        // $receiver_ids = [];
        // $users = User::where("id", '!=',  Auth::user()->id)->whereRelation("rol", function ($role) {
        //     $role->orWhere("role_id", 3);
        // })->get();
        // foreach ($users as  $value) {
        //     array_push($receiver_ids, $value->id);
        // }
        // Notify::create($receiver_ids, [
        //     "type" => "user-create-poe",
        //     "notifiable" => ['App\Models\FormPoe', $formPoe->id],
        //     "sender" => ['App\Models\User', Auth::user()->id],
        //     "message" => "Has requesting for PPMP pending for review.",
        // ]);
        return ["url" => "/form/poe"];
    }
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('forms-access')) {
            abort(403);
        }
        $formPoe = FormPoe::find($request->input('poe_id'));
        $pap_id = ListOfPap::where('paps', $request->input('pap_name'))->pluck('id')->first();
        $formPoe->suggested_pap_id = (isset($pap_id)) ? $pap_id : null;
        $formPoe->creator_id = Auth::user()->id;
        $formPoe->pap_txt = (isset($pap_id)) ? null : $request->input('pap_name');
        $formPoe->geolocation = $request->input('geograpical_loc');
        $formPoe->mfo_id = $request->input('mfo_id');
        $formPoe->key_id = $request->input('kdp_id');
        $formPoe->service_region_id = Auth::user()->serreg_id;
        $formPoe->category_id = $request->input('category_code_id');
        $formPoe->thematic_area_cluster_id = $request->input('thematic_area_cluster');
        $formPoe->locked = '0';
        $formPoe->locker_user_id = null;
        $formPoe->datetime_locked = null;
        $formPoe->total = $request->input('total');
        $formPoe->update();

        FormPoeTargetSector::where('poe_id', $formPoe->id)->delete();
        $target_sectors = $request->input('target_sector');
        foreach ($target_sectors as $target_sector) {
            $formPoeTargetSector = new FormPoeTargetSector;
            $formPoeTargetSector->poe_id = $formPoe->id;
            $formPoeTargetSector->target_sector_id = $target_sector;
            $formPoeTargetSector->save();
        }
        FormPoeTag::where('poe_id', $formPoe->id)->delete();
        $poe_tags = $request->input('form_related');
        foreach ($poe_tags as $poe_tag) {
            $formPoeTag = new FormPoeTag;
            $formPoeTag->poe_id = $formPoe->id;
            $formPoeTag->paptag_id = $poe_tag;
            $formPoeTag->save();
        }
        FormPoeSubPap::where('poe_id', $formPoe->id)->delete();
        $subpaps = $request->input('subpaps');
        foreach ($subpaps as $subpap) {
            $subpap_list_id = ListOfSubPap::where('subpaps', $subpap['sub_pap_name'])->pluck('id')->first();
            $formPoeSubPap = new FormPoeSubPap;
            $formPoeSubPap->poe_id = $formPoe->id;
            $formPoeSubPap->suggested_subpap_id = (isset($subpap_list_id)) ? $subpap_list_id : null;
            $formPoeSubPap->subpap_txt = (isset($subpap_list_id)) ? null : $subpap['sub_pap_name'];
            $formPoeSubPap->quarter_target_id = $subpap['subpap_quarter_target'];
            $formPoeSubPap->save();

            $item_reqs = $subpap['item_reqs'];

            foreach ($item_reqs as $item_req) {
                $item_req_list_id = ListOfItemRequirement::where('ireq', $item_req['item_requirement'])->pluck('id')->first();
                $item_unit_id = Units::where('unit', $item_req['item_unit'])->pluck('id')->first();
                $formPoeItemRequirement = new FormPoeItemRequirement;
                $formPoeItemRequirement->subpap_id = $formPoeSubPap->id;
                $formPoeItemRequirement->account_id = $item_req['item_account_code_id'];
                $formPoeItemRequirement->suggested_itemreq_id = (isset($item_req_list_id)) ? $item_req_list_id : null;
                $formPoeItemRequirement->itemreq_txt = (isset($item_req_list_id)) ? null : $item_req['item_requirement'];
                $formPoeItemRequirement->per_capita_cost = $item_req['item_cost'];
                $formPoeItemRequirement->unit_id = (isset($item_unit_id)) ? $item_unit_id : null;
                $formPoeItemRequirement->unit = (isset($item_unit_id)) ? null : $item_req['item_unit'];
                $formPoeItemRequirement->procurement_mode_id = $item_req['item_procurement_mode'];
                $formPoeItemRequirement->qty_pax = $item_req['item_qty_pax'];
                $formPoeItemRequirement->no_of_days = $item_req['item_days'];
                $formPoeItemRequirement->save();

                $item_req_months = $item_req['item_months'];

                foreach ($item_req_months as $item_req_month) {
                    $formPoeItemRequirementMonth = new FormPoeItemRequirementMonth;
                    $formPoeItemRequirementMonth->item_req_id = $formPoeItemRequirement->id;
                    $formPoeItemRequirementMonth->month = $item_req_month['month'];
                    $formPoeItemRequirementMonth->amount = $item_req_month['amount'];
                    $formPoeItemRequirementMonth->qty = $item_req_month['qty'];
                    $formPoeItemRequirementMonth->save();
                }
            }
        }

        if (@$formPoe->status_id == 2) {

            Notify::create([@$formPoe->creator_id], [
                "type" => "user-update-poe",
                "notifiable" => ['App\Models\FormPoe', $formPoe->id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "POE EDITED HAS BEEN",
            ]);
            $email = new EmailController();
            $email->ppmpEdited(
                array(
                    "receiver" => @$formPoe->creator->email,
                    "subject" => "PPMP EDITED",
                    "poe" => @$formPoe
                )
            );
        }
        return ["url" => "/form/poe"];
    }
    public function getDrafts()
    {
        return FormPoe::where('status', 0)
            ->with(['category', 'creator', 'serviceRegion', 'suggestedPap'])
            ->get();
    }

    public function getPoe(Request $request)
    {
        $relations = ['category', 'creator', 'serviceRegion', 'suggestedPap'];

        if ($request->status == 4 || $request->status == 5 || $request->status == 0) {
            array_push($relations, 'returnable');
            array_push($relations, 'returnable.returner');
        } else if ($request->status == 2) {
            array_push($relations, 'targetSectors.targetSector');
            array_push($relations, 'poeTags.papTag');
            array_push($relations, 'thematicAreaCluster');
            array_push($relations, 'mfo');
            array_push($relations, 'kdp');
        }
        $stage_count = FormPoe::query();
        $stage_count = $stage_count->select(['stage_id', DB::raw("COUNT(1) as row_count")])
            ->where('status_id', 2);

        $formPoe = FormPoe::query();

        if ($request->status != 0) {
            $formPoe = $formPoe->where('status_id', $request->status);
        }

        if (@$request->filters['search_query']) {
            $search_query = $request->filters['search_query'];
            $formPoe = $formPoe->where(function ($q) use ($search_query) {
                $q->where('pap_txt', 'like', '%' . $search_query . '%');
                $q->orWhere(function ($q1) use ($search_query) {
                    $q1->whereRelation('suggestedPap', function ($q2) use ($search_query) {
                        $q2->where('paps', 'like', '%' . $search_query . '%');
                    });
                });
            });
        }
        if (@is_numeric(@$request->filters['stage'])) {
            $formPoe = $formPoe->where('stage_id', $request->filters['stage']);
        }
        if (@is_numeric(@$request->filters['service_region'])) {
            $formPoe = $formPoe->where('service_region_id', $request->filters['service_region']);
            $stage_count = $stage_count->where('service_region_id', $request->filters['service_region']);
        }
        if (@is_numeric(@$request->filters['month'])) {
            $formPoe = $formPoe->whereMonth('created_at', $request->filters['month']);
        }
        if (@is_numeric(@$request->filters['year'])) {
            $formPoe = $formPoe->whereYear('created_at', $request->filters['year']);
            $stage_count = $stage_count->whereYear('created_at', $request->filters['year']);
        }

        if (Auth::user()->hasRole(['Planning Focal/Officer'])) {
            $formPoe = $formPoe->where('service_region_id', Auth::user()->serreg_id);
            $stage_count = $stage_count->where('service_region_id', Auth::user()->serreg_id);
        }

        $formPoe = $formPoe->with($relations)->orderBy('id', 'desc')->paginate(10);
        $stage_count = $stage_count->groupBy(DB::raw("(stage_id)"))
            ->get()->keyBy('stage_id');

        if ($request->status == 2) {
            return [
                "pagination_data" => $formPoe,
                "stages" => $stage_count,
            ];
        } else {
            return $formPoe;
        }
    }
    public function fetchByGroup(Request $request)
    {
        $formPoe = FormPoe::query();
        if(@$request->service_region_id){
            $formPoe = $formPoe->where('service_region_id', $request->service_region_id);
        }
        else if(@$request->kdpkpks){
            $formPoe = $formPoe->where('key_id', $request->kdpkpks);
        }
        else if(@$request->thematic_area_cluster){
            $formPoe = $formPoe->where('thematic_area_cluster_id', $request->thematic_area_cluster);
        }
        else if(@$request->pc_id){
            $pc_id = $request->pc_id;
            $formPoe = $formPoe->whereHas('mfo', function($q) use($pc_id){
                $q->where('pc_id', $pc_id);
            });
        }
        else if(@$request->paptag){
            $paptag_id = $request->paptag;
            $formPoe = $formPoe->whereHas('poeTags', function($q) use($paptag_id){
                $q->where('paptag_id', $paptag_id);
            });
        }
        else if(@$request->target_sector){
            $target_sector_id = $request->target_sector;
            $formPoe = $formPoe->whereHas('targetSectors', function($q) use($target_sector_id){
                $q->where('target_sector_id', $target_sector_id);
            });
        }
        else{
            abort(404);
        }
        $formPoe = $formPoe->whereHas('ppmp', function($q){
            $q->where([['status_id', '2'],['funded', '1']]);
        })
        ->with([
            'suggestedPap',
            'subpap.suggestedSubPap',
            'subpap.quarterTarget',
            'subpap.itemRequirements.suggestedItemRequirement',
            'subpap.itemRequirements.chartOfAccount',
            'subpap.itemRequirements.itemMonths',
            'creator.division_section',
            'serviceRegion',
            'categoryClass.fundChargeability',
            'poeTags.papTag',
            'mfo.priorityClass',
        ])
        ->get()->groupBy('mfo.pc_id');

        return $formPoe;
    }
    public function returnPpmp(Request $request)
    {
        $ppmp_id = $request->input('ppmp_id');
        $reason = $request->input('reason');

        FormPpmp::where('id', $ppmp_id)->update([
            'status_id' => '4',
            'funded' => null,
            'request_status' => null,
        ]);
        $serviceRegions = null;
        $regionFormPPmp = FormPpmp::where("id", $ppmp_id)
            ->with("poe")
            ->first();
        if ($regionFormPPmp) {
            $serviceRegions =  @$regionFormPPmp->poe->service_region_id;
            // return $formPoe;
            if ($serviceRegions) {
                $receiver_ids = [];
                $emailReciever = [];
                $users = User::where("id", '!=',  Auth::user()->id)
                    ->where("serreg_id", $serviceRegions)
                    ->whereRelation("rol", function ($role) {
                        $role->orWhere("role_id", 3);
                    })->get();
                foreach ($users as  $value) {
                    array_push($receiver_ids, $value->id);
                    array_push($emailReciever,  $value->email);
                }
                Notify::create($receiver_ids, [
                    "type" => "user-return-ppmpClassification",
                    "notifiable" => ['App\Models\FormPpmp', $ppmp_id],
                    "sender" => ['App\Models\User', Auth::user()->id],
                    "message" =>  $request->input('type') ?  "BUDGET FORM has been returned" : "PPMP Classification has been returned",
                ]);
                $email = new EmailController();
                $email->returnedPPMP(
                    array(
                        'receiver' => $emailReciever,
                        "subject" => $request->input('type') ? "Returned BUDGET FORM" : "Returned PPMP Classification",
                        "reason"  => $reason
                    )
                );
            }
        }

        return ReturnedForm::create([
            "reason" => $reason,
            "returner_id" => Auth::user()->id,
            "returnable_id" => $ppmp_id,
            "returnable_type" => "App\Models\FormPpmp",
        ]);
    }
    public function return(Request $request)
    {
        $ppmp_id = $request->input('ppmp_id');
        $poe_id = $request->input('poe_id');
        $reason = $request->input('reason');
        $poeCreator = FormPoe::where('id', $poe_id)->with("creator")->first();
        if ($poeCreator) {
            Notify::create([$poeCreator->creator_id], [
                "type" => "user-returned-poe",
                "notifiable" => ['App\Models\FormPoe', $poeCreator->id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "Has Returned POE",
            ]);
            $email = new EmailController();
            $email->ppmpReturned(
                array(
                    "receiver" => $poeCreator->creator->email,
                    "poe" => $poeCreator,
                    "subject" => "POE has Been Updated"
                )
            );
        }

        FormPoe::where('id', $poe_id)->update(['status_id' => 4]);
        FormPpmp::where('id', $ppmp_id)->forceDelete();
        return ReturnedForm::create([
            "reason" => $reason,
            "returner_id" => Auth::user()->id,
            "returnable_id" => $poe_id,
            "returnable_type" => "App\Models\FormPoe",
        ]);
    }
    public function approveClassification(Request $request)
    {
        if (Auth::user()->hasPermissionTo("form-ppmp-classification-all-access")) {
            $ppmp = FormPpmp::find($request->input('id'));
            $ppmp->funded = $ppmp->request_status;
            $ppmp->update();

            $regionFormPPmp = FormPpmp::where("id", $request->input('id'))
                ->with("poe")
                ->first();
            if ($regionFormPPmp) {
                $serviceRegions =  @$regionFormPPmp->poe->service_region_id;
                // return $formPoe;
                if ($serviceRegions) {
                    $receiver_ids = [];
                    $emailReciever = [];
                    $users = User::where("id", '!=',  Auth::user()->id)
                        ->where("serreg_id", $serviceRegions)
                        ->whereRelation("rol", function ($role) {
                            $role->where("role_id", 3)->orWhere("role_id", 4);
                        })->get();
                    foreach ($users as  $value) {
                        array_push($receiver_ids, $value->id);
                        array_push($emailReciever,  $value->email);
                    }
                    $type = $regionFormPPmp->request_status == '0' ? "Unfunded" : "Funded";
                    Notify::create($receiver_ids, [
                        "type" => "user-aproved-ppmpClassification",
                        "notifiable" => ['App\Models\FormPpmp', $request->input('id')],
                        "sender" => ['App\Models\User', Auth::user()->id],
                        "message" => "Aproved PPMP CLassification to <strong>" . $type . "</strong>",
                    ]);
                    $email = new EmailController();

                    $email->fundedAndUnFundedSegregations(
                        array(
                            'receiver' => $emailReciever,
                            "subject" => "Aproved PPMP CLassification",
                            "type"  =>    $type
                        )
                    );
                }
            }
            return ["error" => false];
        }
        return ["error" => true];
    }
    public function lockUnlock(Request $request)
    {
        $poe = FormPoe::find($request->input('id'));

        if ($poe->locked == '0') {
            $poe->locked = '1';
            $poe->locker_user_id = Auth::user()->id;
            $poe->datetime_locked = Carbon::now()->addHours(5);
            $poe->update();
            return $poe;
        } else {
            if (Auth::user()->id == $poe->locker_user_id) {
                $poe->locked = '0';
                $poe->locker_user_id = null;
                $poe->datetime_locked = null;
                $poe->update();
                return $poe;
            }
        }
        return ['status' => 'failed'];
    }
    public function lockUnlockPpmp(Request $request)
    {
        $ppmp = FormPpmp::find($request->input('id'));
        if ($ppmp->locked == '0') {
            $ppmp->locked = '1';
            $ppmp->locker_user_id = Auth::user()->id;
            $ppmp->datetime_locked = Carbon::now()->addHours(5);
            $ppmp->update();
            return $ppmp;
        } else {
            if (Auth::user()->id == $ppmp->locker_user_id) {
                $ppmp->locked = '0';
                $ppmp->locker_user_id = null;
                $ppmp->datetime_locked = null;
                $ppmp->update();
                return $ppmp;
            }
        }
        return ['status' => 'failed'];
    }
    public function publish(Request $request)
    {
        $id = $request->input('id');
        $formPpmp = new FormPpmp;
        $formPpmp->poe_id = $id;
        $formPpmp->status_id = 3;
        $formPpmp->enduser_unit = "Ako pala to";
        $formPpmp->save();
        $receiver_emails = [];
        $receiver_ids = [];
        $serviceReg = FormPoe::where('id', $id)->first();

        $users = User::where("id", '!=',  Auth::user()->id)
            ->where("serreg_id", @$serviceReg->service_region_id)
            ->whereRelation("rol", function ($role) {
                $role->orWhere("role_id", 3);
            })->get();
        foreach ($users as  $value) {
            array_push($receiver_ids, $value->id);
            array_push($receiver_emails,  $value->email);
        }

        Notify::create($receiver_ids, [
            "type" => "user-published-poe",
            "notifiable" => ['App\Models\FormPpmp', $formPpmp->id],
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => "Has Published POE and ready for review for PPMP.",
        ]);
        $email = new EmailController();
        $email->publishedPOE(
            array(
                "receiver" => $receiver_emails,
                "subject" => "Publised POE",
                "poe" =>  $formPpmp
            )
        );

        return FormPoe::where('id', $id)->update(['status_id' => 2]);
    }
    public function delete(Request $request)
    {
        return FormPoe::where('id', $request->input('id'))->delete();
    }
    public function deletePpmp(Request $request)
    {
        return FormPpmp::where('id', $request->input('id'))->delete();
    }
    public function resolvePpmp(Request $request)
    {
        $formPpmp = FormPpmp::find($request->input('id'));
        $formPpmp->status_id = 5;
        $formPpmp->update();

        $receiver_ids = [];
        $receiver_emails = [];
        $users = User::where("id", '!=',  Auth::user()->id)->whereRelation("rol", function ($role) {
            $role->where("role_id", 3);
        })->get();
        foreach ($users as  $value) {
            array_push($receiver_ids, $value->id);
            array_push($receiver_emails, $value->email);
        }
        if (@$formPpmp) {
            Notify::create(
                $receiver_ids,
                [
                    "type" => "user-resolve-poe",
                    "notifiable" => ['App\Models\FormPpmp', @$formPpmp->id],
                    "sender" => ['App\Models\User', Auth::user()->id],
                    "message" => "Has been resolve and pending for review",
                ]
            );
            $email = new EmailController();
            $email->ppmpResolved(
                array(
                    "receiver" => $receiver_emails,
                    "subject" => "Resolved POE",
                    "ppmp" => @$formPpmp
                )
            );
        }
        return $formPpmp;
    }
    public function resolve(Request $request)
    {
        $formPpmp = new FormPpmp;
        $formPpmp->poe_id = $request->input('id');
        $formPpmp->status_id = 3;
        $formPpmp->enduser_unit = "";
        $formPpmp->save();
        $serviceReg  = FormPoe::where('id', $request->input('id'))->first();
        $receiver_ids = [];
        $receiver_emails = [];
        $users = User::where("id", '!=',  Auth::user()->id)
            ->where("serreg_id", @$serviceReg->service_region_id)
            ->whereRelation("rol", function ($role) {
                $role->where("role_id", 3);
            })->get();
        foreach ($users as  $value) {
            array_push($receiver_ids, $value->id);
            array_push($receiver_emails, $value->email);
        }
        if (@$formPpmp) {
            Notify::create(
                $receiver_ids,
                [
                    "type" => "user-resolve-poe",
                    "notifiable" => ['App\Models\FormPpmp', @$formPpmp->id],
                    "sender" => ['App\Models\User', Auth::user()->id],
                    "message" => "Has been resolve and pending for review",
                ]
            );
            $email = new EmailController();
            $email->ppmpResolved(
                array(
                    "receiver" => $receiver_emails,
                    "subject" => "Resolved POE",
                    "ppmp" => @$formPpmp
                )
            );
        }

        return FormPoe::where('id', $request->input('id'))->update(['status_id' => 5]);
    }
    public function publishPpmp(Request $request)
    {
        $id = $request->input('id');
        $ppmp = FormPpmp::where('id', $id)->with("poe")->first();
        FormPoe::where('id', $ppmp->poe_id)->update(['status_id' => '2']);
        if ($ppmp) {
            $receiver_ids = [];
            $receiver_emails = [];
            $users = User::where("id", '!=',  Auth::user()->id)
                ->where("serreg_id",  $ppmp->poe->service_region_id)
                ->whereRelation("rol", function ($role) {
                    $role->orWhere("role_id", 2);
                })->get();
            foreach ($users as  $value) {
                array_push($receiver_ids, $value->id);
                array_push($receiver_emails, $value->email);
            }
            Notify::create($receiver_ids, [
                "type" => "user-published-poe",
                "notifiable" => ['App\Models\FormPpmp', $ppmp->id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "Has Published PMPP  and pending for classification.",
            ]);
            $email = new EmailController();
            $email->publishedPPMP(
                array(
                    "receiver" => $receiver_emails,
                    "subject" => "PUBLISHED PPMP ",
                    "ppmp" => $ppmp
                )
            );
        }
        return FormPpmp::where('id', $id)->update(['status_id' => 2]);
    }

    public function formPpmp()
    {
        if (!Auth::user()->hasPermissionTo('form-ppmp-access')) {
            abort(403);
        }

        return view('pages.form.ppmp');
    }
    public function getPpmp(Request $request)
    {
        $filters = $request->filters;
        if (Auth::user()->hasRole(['Planning Focal/Officer'])) {
            $filters['service_region'] = Auth::user()->serreg_id;
        }
        $stage_count = [];
        if ($request->status == 2) {
            $stage_count = FormPpmp::query();
            $stage_count = $stage_count->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
                ->select(['stage_id', DB::raw("COUNT(1) as row_count")])
                ->groupBy(DB::raw("(stage_id)"))
                ->where('form_ppmps.status_id', 2);
            if (@is_numeric(@$filters['service_region'])) {
                $stage_count = $stage_count->where('service_region_id', $filters['service_region']);
            }
            if (@is_numeric(@$filters['year'])) {
                $stage_count = $stage_count->whereYear('form_ppmps.created_at', $filters['year']);
            }
            $stage_count = $stage_count->get()->keyBy('stage_id');
        }


        $formPpmp = FormPpmp::query();

        if ($request->status != 0) {
            $formPpmp = $formPpmp->where('status_id', $request->status);
        }

        $formPpmp = $formPpmp->whereRelation('poe', function ($query) use ($filters) {
            if (@$filters['search_query']) {
                $search_query = $filters['search_query'];
                $query = $query->where(function ($q) use ($search_query) {
                    $q->where('pap_txt', 'like', '%' . $search_query . '%');
                    $q->orWhere(function ($q1) use ($search_query) {
                        $q1->whereRelation('suggestedPap', function ($q2) use ($search_query) {
                            $q2->where('paps', 'like', '%' . $search_query . '%');
                        });
                    });
                });
            }
            if (@is_numeric(@$filters['stage'])) {
                $query = $query->where('stage_id', $filters['stage']);
            }
            if (@is_numeric(@$filters['service_region'])) {
                $query = $query->where('service_region_id', $filters['service_region']);
            }
            if (@is_numeric(@$filters['month'])) {
                $query = $query->whereMonth('created_at', $filters['month']);
            }
            if (@is_numeric(@$filters['year'])) {
                $query = $query->whereYear('created_at', $filters['year']);
            }
        });

        $formPpmp = $formPpmp->with([
            'poe',
            'poe.creator',
            'poe.category',
            'returnable.returner',
            'poe.serviceRegion',
            'poe.suggestedPap',
            'poe.mfo',
            'poe.kdp',
            'poe.thematicAreaCluster',
            'poe.targetSectors.targetSector',
            'poe.poeTags.papTag'
        ])->orderBy('id', 'desc')->paginate(10);
        if ($request->status == 2) {
            return [
                "pagination_data" => $formPpmp,
                "stages" => $stage_count,
            ];
        } else {
            return $formPpmp;
        }
    }
    public function getUnclassifiedPpmps(Request $request)
    {
        $filters = $request->filters;
        $formPpmp = FormPpmp::query();

        if (@is_numeric($request->request_status)) {
            $formPpmp = $formPpmp->where('request_status', $request->request_status);
        } else if (@$request->request_status == "all") {
            $formPpmp = $formPpmp->whereNull('request_status');
        }

        $formPpmp = $formPpmp->whereRelation('poe', function ($query) use ($filters) {
            if (@$filters['search_query']) {
                $search_query = $filters['search_query'];
                $query = $query->where(function ($q) use ($search_query) {
                    $q->where('pap_txt', 'like', '%' . $search_query . '%');
                    $q->orWhere(function ($q1) use ($search_query) {
                        $q1->whereRelation('suggestedPap', function ($q2) use ($search_query) {
                            $q2->where('paps', 'like', '%' . $search_query . '%');
                        });
                    });
                });
            }
            if (@is_numeric(@$filters['stage'])) {
                $query = $query->where('stage_id', $filters['stage']);
            }
            if (@is_numeric(@$filters['service_region'])) {
                $query = $query->where('service_region_id', $filters['service_region']);
            }
            if (@is_numeric(@$filters['month'])) {
                $query = $query->whereMonth('created_at', $filters['month']);
            }
            if (@is_numeric(@$filters['year'])) {
                $query = $query->whereYear('created_at', $filters['year']);
            }
        });



        $formPpmp = $formPpmp->where(function ($q) {
            $q->where('status_id', 2)
                ->orWhere('status_id', 5);
        })
            ->whereNull('funded')
            ->with(['poe', 'poe.creator', 'poe.category', 'poe.serviceRegion', 'poe.suggestedPap'])
            ->paginate(10);

        return $formPpmp;
    }
    public function getFundedPpmps(Request $request)
    {
        $filters = $request->filters;
        $formPpmp = FormPpmp::query();

        $formPpmp = $formPpmp->where([['status_id', 2], ['funded', '1']]);

        $formPpmp = $formPpmp->whereRelation('poe', function ($query) use ($filters) {
            if (@$filters['search_query']) {
                $search_query = $filters['search_query'];
                $query = $query->where(function ($q) use ($search_query) {
                    $q->where('pap_txt', 'like', '%' . $search_query . '%');
                    $q->orWhere(function ($q1) use ($search_query) {
                        $q1->whereRelation('suggestedPap', function ($q2) use ($search_query) {
                            $q2->where('paps', 'like', '%' . $search_query . '%');
                        });
                    });
                });
            }
            if (@is_numeric(@$filters['stage'])) {
                $query = $query->where('stage_id', $filters['stage']);
            }
            if (@is_numeric(@$filters['service_region'])) {
                $query = $query->where('service_region_id', $filters['service_region']);
            }
            if (@is_numeric(@$filters['month'])) {
                $query = $query->whereMonth('created_at', $filters['month']);
            }
            if (@is_numeric(@$filters['year'])) {
                $query = $query->whereYear('created_at', $filters['year']);
            }
        });

        $formPpmp = $formPpmp->with(['poe', 'poe.creator', 'poe.category', 'poe.serviceRegion', 'poe.suggestedPap'])->orderBy('id', 'desc')->paginate(10);
        return $formPpmp;
    }
    public function getUnfundedPpmps(Request $request)
    {
        $filters = $request->filters;
        $formPpmp = FormPpmp::query();

        $formPpmp = $formPpmp->where([['status_id', 2], ['funded', '0']]);

        $formPpmp = $formPpmp->whereRelation('poe', function ($query) use ($filters) {
            if (@$filters['search_query']) {
                $search_query = $filters['search_query'];
                $query = $query->where(function ($q) use ($search_query) {
                    $q->where('pap_txt', 'like', '%' . $search_query . '%');
                    $q->orWhere(function ($q1) use ($search_query) {
                        $q1->whereRelation('suggestedPap', function ($q2) use ($search_query) {
                            $q2->where('paps', 'like', '%' . $search_query . '%');
                        });
                    });
                });
            }
            if (@is_numeric(@$filters['stage'])) {
                $query = $query->where('stage_id', $filters['stage']);
            }
            if (@is_numeric(@$filters['service_region'])) {
                $query = $query->where('service_region_id', $filters['service_region']);
            }
            if (@is_numeric(@$filters['month'])) {
                $query = $query->whereMonth('created_at', $filters['month']);
            }
            if (@is_numeric(@$filters['year'])) {
                $query = $query->whereYear('created_at', $filters['year']);
            }
        });

        $formPpmp = $formPpmp->with(['poe', 'poe.creator', 'poe.category', 'poe.serviceRegion', 'poe.suggestedPap'])->orderBy('id', 'desc')->paginate(10);
        return $formPpmp;
    }
    public function savePpmpClassifications(Request $request)
    {
        // $funded = $request->input('funded');
        // $unfunded = $request->input('unfunded');
        // FormPpmp::whereIn("id", $funded)->update(["funded"=>'1']);
        // FormPpmp::whereIn("id", $unfunded)->update(["funded"=>'0']);
        if (@is_numeric(@$request->request_status)) {
            FormPpmp::where("id", $request->id)->update([
                "request_status" => $request->request_status,
                "status_id" => '2',
            ]);
            $regionFormPPmp = FormPpmp::where("id", $request->id)
                ->with("poe")
                ->first();
            if ($regionFormPPmp) {
                $serviceRegions =  @$regionFormPPmp->poe->service_region_id;
                // return $formPoe;
                if ($serviceRegions) {
                    $receiver_ids = [];
                    $emailReciever = [];
                    $users = User::where("id", '!=',  Auth::user()->id)
                        ->where("serreg_id", $serviceRegions)
                        ->whereRelation("rol", function ($role) {
                            $role->orWhere("role_id", 3);
                        })->get();
                    foreach ($users as  $value) {
                        array_push($receiver_ids, $value->id);
                        array_push($emailReciever,  $value->email);
                    }
                    $typeOf = $request->request_status == '0' ? "Unfunded" : "Funded";
                    $collection =  Notification::whereIn("receiver_id", $receiver_ids)
                        ->where("notif_type", "user-segregated-ppmpClassification")
                        ->get(['id']);
                    Notification::destroy($collection->toArray());
                    Notify::create($receiver_ids, [
                        "type" => "user-segregated-ppmpClassification",
                        "notifiable" => ['App\Models\FormPpmp', $request->id],
                        "sender" => ['App\Models\User', Auth::user()->id],
                        "message" => "PPMP Classification has been Segregated to <strong>" . $typeOf . "</strong>",
                    ]);
                    return  $receiver_ids;
                }
                return "asdasd";
            }
            return "waray ka send";
        } else {
            FormPpmp::where("id", $request->id)->update([
                "request_status" => null,
            ]);
        }
        return ["status" => "success"];
    }
    public function viewPoe($id)
    {
        $poe = FormPoe::where('id', $id)
            ->with([
                'creator',
                'category',
                'serviceRegion',
                'suggestedPap',
                'targetSectors.targetSector',
                'poeTags.papTag',
                'thematicAreaCluster',
                'mfo',
                'kdp',
            ])
            ->first();
        if (!@$poe) {
            abort(404);
        }
        $fc = FundChargeabilityClass::with(['allotmentClass', 'fundChargeability'])->get();
        $service_regions = ServiceRegion::all();
        $target_sectors = TargetSector::all();
        $pap_tags = PapTag::all();
        $procurement_modes = ProcurementMode::all();
        return view('pages.form.poe-view', [
            "poe" => $poe,
            "fc" => $fc,
            "service_regions" => $service_regions,
            "target_sectors" => $target_sectors,
            "procurement_modes" => $procurement_modes,
            "pap_tags" => $pap_tags,
            "type" => "poe",
        ]);
    }
    public function viewPpmpReport($id)
    {
        return $this->viewPpmp($id);
    }
    public function viewPoeReport($id)
    {
        return $this->viewPoe($id);
    }
    public function viewPpmp($id)
    {
        $ppmp = FormPpmp::where('id', $id)
            ->with([
                'poe',
                'poe.creator',
                'poe.category',
                'poe.serviceRegion',
                'poe.suggestedPap',
                'poe.targetSectors.targetSector',
                'poe.poeTags.papTag',
                'poe.mfo',
                'poe.kdp',
                'poe.thematicAreaCluster'
            ])
            ->first();
        if (!@$ppmp) {
            abort(404);
        }
        $fc = FundChargeabilityClass::with(['allotmentClass', 'fundChargeability'])->get();
        $service_regions = ServiceRegion::all();
        $target_sectors = TargetSector::all();
        $pap_tags = PapTag::all();
        $procurement_modes = ProcurementMode::all();

        return view('pages.form.ppmp-view', [
            "ppmp" => $ppmp,
            "fc" => $fc,
            "service_regions" => $service_regions,
            "target_sectors" => $target_sectors,
            "procurement_modes" => $procurement_modes,
            "pap_tags" => $pap_tags,
        ]);
    }
    public function editPoe($id)
    {
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        $lockLimitTime = Carbon::parse($timestamp)->addHours(5);

        $poe = FormPoe::find($id);
        if (!$poe) {
            abort(404);
        }
        $user = Auth::user();

        if ($poe->status_id == 2) {
            $ppmp = FormPpmp::where('poe_id', $poe->id)->first();
            if (@$ppmp) {
                if ($ppmp->locked == '1' && $ppmp->datetime_locked->gte(Carbon::now())) {
                    if ($ppmp->locker_user_id != $user->id) {
                        return view('pages.form.form-locked', [
                            "name" => $ppmp->userLocker->firstname . " " . $ppmp->userLocker->lastname,
                            "formname" => $poe->pap_txt ?: $poe->suggestedPap->paps,
                        ]);
                    }
                } else {
                    $ppmp->locked = '1';
                    $ppmp->locker_user_id = $user->id;
                    $ppmp->datetime_locked = $lockLimitTime;
                    $ppmp->update();
                }
            }
        }


        if ($poe->locked == '1' && $poe->datetime_locked->gte(Carbon::now())) {
            if ($poe->locker_user_id != $user->id) {
                return view('pages.form.form-locked', [
                    "name" => $poe->userLocker->firstname . " " . $poe->userLocker->lastname,
                    "formname" => $poe->pap_txt ?: $poe->suggestedPap->paps,
                ]);
            }
        } else if ($poe->status_id != 2) {
            $poe->locked = '1';
            $poe->locker_user_id = $user->id;
            $poe->datetime_locked = $lockLimitTime;
            $poe->update();
        }

        $fc = FundChargeabilityClass::with(['allotmentClass', 'fundChargeability'])->get();
        $service_regions = ServiceRegion::all();
        $target_sectors = TargetSector::all();
        $pap_tags = PapTag::all();
        $procurement_modes = ProcurementMode::all();
        return view('pages.form.edit-poe', [
            "poe" => $poe,
            "fc" => $fc,
            "service_regions" => $service_regions,
            "target_sectors" => $target_sectors,
            "procurement_modes" => $procurement_modes,
            "pap_tags" => $pap_tags,
            "thematicAreasClusters" => ThematicAreasCluster::all(),
            "quarterTargets" => QuarterTarget::all(),
        ]);
    }
    public function getSubpaps(Request $request)
    {
        $poe_id = $request->input('poe_id');
        $subpaps = FormPoeSubPap::where('poe_id', $poe_id)
            ->with([
                'suggestedSubPap',
                'itemRequirements.itemMonths',
                'itemRequirements.chartOfAccount',
                'itemRequirements.suggestedItemRequirement',
                'itemRequirements.procurementMode',
                'itemRequirements.suggestedUnit',
                'quarterTarget',
            ])
            ->get();
        return $subpaps;
    }

    public function searchAcountCode()
    {
        $query = request('query');
        $except = request('except') ?: [];
        $fcc_id = request('fcc_id');

        $result = FundChargeabilityClassAccount::whereNotIn('id', $except)
            ->whereRelation('chartAccount', function ($q) use ($query) {
                $q->where('code', 'like', '%' . $query . '%');
                $q->orWhere('expense_object', 'like', '%' . $query . '%');
            })
            ->with('chartAccount')
            ->where('fcc_id', $fcc_id)
            ->take(5)
            ->get();
        return $result;
    }
    public function searchItemRequirement()
    {
        $query = request('query');
        $result = ListOfItemRequirement::where('ireq', 'like', '%' . $query . '%')
            ->take(5)
            ->get();
        return $result;
    }
    public function searchSubpap()
    {
        $query = request('query');
        $result = ListOfSubPap::where('subpaps', 'like', '%' . $query . '%')
            ->take(5)
            ->get();
        return $result;
    }
    public function searchPap()
    {
        $query = request('query');
        $result = ListOfPap::where('paps', 'like', '%' . $query . '%')
            ->take(5)
            ->get();
        return $result;
    }
    public function searchUnit()
    {
        $query = request('query');
        $result = Units::where('unit', 'like', '%' . $query . '%')
            ->take(5)
            ->get();
        return $result;
    }

    public function getBudgetFundedReport(Request $request)
    {
        $filters = $request->filters;
        if (Auth::user()->hasRole(['Planning Focal/Officer'])) {
            $filters['service_region'] = Auth::user()->serreg_id;
        }

        $stage_count = FormPpmp::query();

        $stage_count = $stage_count->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
            ->select(['stage_id', DB::raw("COUNT(1) as row_count")])
            ->groupBy(DB::raw("(stage_id)"))
            ->where('form_ppmps.status_id', 2);



        $formPpmp = FormPpmp::query();

        $formPpmp = $formPpmp->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
            ->join('service_regions', 'form_poes.service_region_id', '=', 'service_regions.id')
            ->select('form_ppmps.*', 'form_poes.stage_id', 'form_poes.service_region_id', 'service_regions.accronym', 'service_regions.service_region', DB::raw('YEAR(form_ppmps.created_at) year, MONTH(form_ppmps.created_at) month, SUM(total) budget'))
            ->where([['form_ppmps.status_id', 2], ['stage_id', $request->filters['stage']], ['funded', '1']]);

        if (@is_numeric(@$filters['service_region'])) {
            $formPpmp = $formPpmp->where('service_region_id', $filters['service_region']);
            $stage_count = $stage_count->where('service_region_id', $filters['service_region']);
        }
        if (@is_numeric(@$filters['year'])) {
            $formPpmp = $formPpmp->whereYear('form_ppmps.created_at', $filters['year']);
            $stage_count = $stage_count->whereYear('form_ppmps.created_at', $filters['year']);
        }

        $formPpmp = $formPpmp->orderBy('id', 'desc')
            ->groupby('year', 'service_region_id')
            ->paginate(10);

        $stage_count = $stage_count->get()->keyBy('stage_id');

        return [
            "pagination_data" => $formPpmp,
            "stages" => $stage_count,
        ];

        return $formPpmp;
    }
    public function getBudgetUnFundedReport(Request $request)
    {
        $filters = $request->filters;
        if (Auth::user()->hasRole(['Planning Focal/Officer'])) {
            $filters['service_region'] = Auth::user()->serreg_id;
        }
        $stage_count = FormPpmp::query();

        $stage_count = $stage_count->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
            ->select(['stage_id', DB::raw("COUNT(1) as row_count")])
            ->groupBy(DB::raw("(stage_id)"))
            ->where('form_ppmps.status_id', 2);



        $formPpmp = FormPpmp::query();

        $formPpmp = $formPpmp->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
            ->join('service_regions', 'form_poes.service_region_id', '=', 'service_regions.id')
            ->select('form_ppmps.*', 'form_poes.stage_id', 'form_poes.service_region_id', 'service_regions.accronym', 'service_regions.service_region', DB::raw('YEAR(form_ppmps.created_at) year, MONTH(form_ppmps.created_at) month, SUM(total) budget'))
            ->where([['form_ppmps.status_id', 2], ['stage_id', $request->filters['stage']], ['funded', '0']]);

        if (@is_numeric(@$filters['service_region'])) {
            $formPpmp = $formPpmp->where('service_region_id', $filters['service_region']);
            $stage_count = $stage_count->where('service_region_id', $filters['service_region']);
        }
        if (@is_numeric(@$filters['year'])) {
            $formPpmp = $formPpmp->whereYear('form_ppmps.created_at', $filters['year']);
            $stage_count = $stage_count->whereYear('form_ppmps.created_at', $filters['year']);
        }

        $formPpmp = $formPpmp->orderBy('id', 'desc')
            ->groupby('year', 'service_region_id')
            ->paginate(10);

        $stage_count = $stage_count->get()->keyBy('stage_id');

        return [
            "pagination_data" => $formPpmp,
            "stages" => $stage_count,
        ];

        return $formPpmp;
    }
    public function getAPBReport(Request $request)
    {
        $filters = $request->filters;
        if (Auth::user()->hasRole(['Planning Focal/Officer'])) {
            $filters['service_region'] = Auth::user()->serreg_id;
        }

        $stage_count = FormPpmp::query();

        $stage_count = $stage_count->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
            ->select(['stage_id', DB::raw("COUNT(1) as row_count")])
            ->groupBy(DB::raw("(stage_id)"))
            ->where([['form_ppmps.status_id', 2], ['form_ppmps.funded', '1']]);

        $formPpmp = FormPpmp::query();

        $formPpmp = $formPpmp->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
            ->join('service_regions', 'form_poes.service_region_id', '=', 'service_regions.id')
            ->select('form_ppmps.*', 'form_poes.stage_id', 'form_poes.service_region_id', 'service_regions.accronym', 'service_regions.service_region', DB::raw('YEAR(form_ppmps.created_at) year, MONTH(form_ppmps.created_at) month, SUM(total) budget'))
            ->where([['form_ppmps.status_id', 2], ['stage_id', $request->filters['stage']], ['form_ppmps.funded', '1']]);

        if (@is_numeric(@$filters['service_region'])) {
            $formPpmp = $formPpmp->where('service_region_id', $filters['service_region']);
            $stage_count = $stage_count->where('service_region_id', $filters['service_region']);
        }
        if (@is_numeric(@$filters['year'])) {
            $formPpmp = $formPpmp->whereYear('form_ppmps.created_at', $filters['year']);
            $stage_count = $stage_count->whereYear('form_ppmps.created_at', $filters['year']);
        }

        $formPpmp = $formPpmp->orderBy('id', 'desc')
            ->groupby('year', 'service_region_id')
            ->paginate(10);

        $stage_count = $stage_count->get()->keyBy('stage_id');

        return [
            "pagination_data" => $formPpmp,
            "stages" => $stage_count,
        ];

        return $formPpmp;
    }
    public function getOPCReport(Request $request)
    {
        $filters = $request->filters;

        $formOpc = FormOpc::query();

        $formOpc = $formOpc->join('service_regions', 'form_opcs.serreg_id', '=', 'service_regions.id')
            ->select('form_opcs.*', 'service_regions.accronym', 'service_regions.service_region');

        if (@is_numeric(@$filters['semester'])) {
            $formOpc = $formOpc->where('semester', $filters['semester']);
        }
        if (@is_numeric(@$filters['service_region'])) {
            $formOpc = $formOpc->where('serreg_id', $filters['service_region']);
        }
        if (@is_numeric(@$filters['year'])) {
            $formOpc = $formOpc->where('year', $filters['year']);
        }

        $formOpc = $formOpc->orderBy('id', 'desc')
            ->paginate(10);

        $formOpc->append('budget');

        return $formOpc;
    }


    public function test(Request $request)
    {
        $relations = ['category', 'creator', 'serviceRegion', 'suggestedPap'];
        array_push($relations, 'returnable');
        array_push($relations, 'returnable.returner');
        array_push($relations, 'targetSectors.targetSector');
        array_push($relations, 'poeTags.papTag');
        array_push($relations, 'thematicAreaCluster');
        array_push($relations, 'mfo');
        array_push($relations, 'kdp');

        $stage_count = FormPoe::query();
        $stage_count = $stage_count->select(['stage_id', DB::raw("COUNT(1) as row_count")])
            ->where('status_id', 2);

        $formPoe = FormPoe::query();

        if ($request->status != 0) {
            $formPoe = $formPoe->where('status_id', $request->status);
        }

        if (@$request->filters['search_query']) {
            $search_query = $request->filters['search_query'];
            $formPoe = $formPoe->where(function ($q) use ($search_query) {
                $q->where('pap_txt', 'like', '%' . $search_query . '%');
                $q->orWhere(function ($q1) use ($search_query) {
                    $q1->whereRelation('suggestedPap', function ($q2) use ($search_query) {
                        $q2->where('paps', 'like', '%' . $search_query . '%');
                    });
                });
            });
        }
        if (@is_numeric(@$request->filters['stage'])) {
            $formPoe = $formPoe->where('stage_id', $request->filters['stage']);
        }
        if (@is_numeric(@$request->filters['service_region'])) {
            $formPoe = $formPoe->where('service_region_id', $request->filters['service_region']);
            $stage_count = $stage_count->where('service_region_id', $request->filters['service_region']);
        }
        if (@is_numeric(@$request->filters['month'])) {
            $formPoe = $formPoe->whereMonth('created_at', $request->filters['month']);
        }
        if (@is_numeric(@$request->filters['year'])) {
            $formPoe = $formPoe->whereYear('created_at', $request->filters['year']);
            $stage_count = $stage_count->whereYear('created_at', $request->filters['year']);
        }

        $formPoe = $formPoe->with($relations)->orderBy('id', 'desc')->first();
        // $stage_count = $stage_count->groupBy(DB::raw("(stage_id)"))->first();
        // return $formPoe;
        return view('pages.form.test-poe', ["d" => $formPoe]);
    }
    public function recieverNotifAndEmail($id)
    {
    }
    public function PPMPDUE()
    {

        $userType = User::where("id",  Auth::user()->id)
            ->whereRelation("rol", function ($role) {
                $role->where("role_id", 3);
            })->first();
        if ($userType) {
            $notifys = Notification::where("receiver_id", @$userType->id)
                ->where(
                    "notif_type",
                    "user-due-ppmp"
                )->get();
            $notify = [];

            foreach ($notifys as $key => $value) {
                array_push($notify,  $value->notifiable_id);
            }

            $start_raw =  Carbon::today()->toDateString();

            $duely = Setting::where("value", $start_raw)
                ->get();
            foreach ($duely as  $value) {

                $valueTrue = false;

                foreach ($notify as $key => $not) {
                    if ($value->id == $not) {
                        $valueTrue = true;
                    } else {
                        $valueTrue = false;
                    }
                }
                if (!$valueTrue) {
                    Notify::create([$userType->id], [
                        "type" => "user-due-ppmp",
                        "notifiable" => ['App\Models\Setting', $value->id],
                        "sender" => ['App\Models\User', Auth::user()->id],
                        "message" => "DUE PPMP INCOMING",
                    ]);
                }
            }
            return $notify;
        }
    }
    public function getAPBdata(Request $request)
    {
        $stage_id = $request->stage_id;
        $year = $request->year;
        $service_region_id = $request->service_region_id;
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
            })->get();
        $total_budget = $formPpmp->sum('poe.total');
        $formPpmp = $formPpmp->groupBy('poe.categoryClass.fundChargeability.id');
        return ['form_ppmp' => $formPpmp, 'fund_chargeability' => $fc, 'total_budget' => $total_budget];
    }
}
