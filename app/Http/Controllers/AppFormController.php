<?php

namespace App\Http\Controllers;

use App\Models\FormApp;
use App\Models\FormAppRow;
use App\Models\FormPpmp;
use App\Models\FundChargeability;
use App\Models\Setting;
use App\Models\ServiceRegion;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Crypt;
class AppFormController extends Controller
{
    public function encryptUrlParams(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('forms-access')) {
            abort(403);
        }

        $service_region = @$request->input('app-service-region');
        $year = @$request->input('app-form-year');

        if(auth()->user()->hasRole(['Administrator']) || auth()->user()->hasRole(['Developer'])){
            $service_region = @$request->input('app-service-region');
        }
        else{
            $service_region = Auth::user()->serreg_id;
        }

        if (!@$year || !@$service_region) {
            abort(404);
        }

        $parameter = [
            "year" => $year,
            "service_region_id" => $service_region,
        ];
        $encrypted_parameter = Crypt::encrypt($parameter);
        return redirect('form/app-form/create/' . $encrypted_parameter);
    }

    public function show()
    {
        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'APP Form', 'route' => '#'],
                ],
                'page_title' => ' Annual Procurement Plan (APP)',
                "sidebar_id" => "#li_appform",
            ]);
        }
        $stage_id = Stage::where('active', '1')->first()->id;
        $service_regions = ServiceRegion::all();
        $years_for_create = [];
        for($i = date("Y"); $i <= (date("Y") + 6); $i++){
            array_push($years_for_create, $i);
        }

        return view("pages.form.app-form", [
            'years_for_create' => $years_for_create,
            'service_regions' => $service_regions,
        ]);
    }
    public function showReport()
    {
        return view("pages.reports.app-form");
    }
    public function create($parameter)
    {
        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'APP Form', 'route' => '#'],
                ],
                'page_title' => ' Annual Procurement Plan (APP)',
                "sidebar_id" => "#li_appform",
            ]);
        }

        $decrypted_parameter = Crypt::decrypt($parameter);
        $stage_id = Stage::where('active', '1')->first()->id;
        $appForm = FormApp::where([
            ['year', $decrypted_parameter['year']],
            ['stage_id', $stage_id],
            ['service_region_id', $decrypted_parameter['service_region_id']],
        ])->first();

        if(@$appForm){
            return redirect('/form/app-form/edit/'.$appForm->id);
        }
        else{
            return view("pages.form.app-form-create", $decrypted_parameter);
        }
    }
    public function edit($id)
    {
        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'APP Form', 'route' => '#'],
                ],
                'page_title' => ' Annual Procurement Plan (APP)',
                "sidebar_id" => "#li_appform",
            ]);
        }
        
        $appForm = FormApp::find($id);
        if(@$appForm){
            return view("pages.form.app-form-create", [
                "year"=>$appForm->year,
                "service_region_id"=>$appForm->service_region_id,
            ]);
        }
        return abort(404);
    }
    public function view($id)
    {
        $appForm = FormApp::find($id);
        if(@$appForm){
            return view("pages.form.app-form-view", [
                "year"=>$appForm->year, 
                "id"=>$id,
                "service_region_id"=>$appForm->service_region_id
            ]);
        }
        return abort(404);
    }
    public function delete(Request $request)
    {
        $appForm = FormApp::where('id',$request->id)->delete();
        if(@$appForm){
            return ['status'=>'success'];
        }
        return ['status'=>'failed'];
    }
    public function fetch(Request $request)
    {
        $stage_id = Stage::where('active', '1')->first()->id;
        $service_region_id = $request->service_region_id;
        $year = $request->year;
        $formPpmp = FormPpmp::query();
        $formPpmp = $formPpmp->where('funded', '1')
        ->with([
            'poe',
            'poe.suggestedPap',
            'poe.subpap.suggestedSubPap',
            'poe.subpap.itemRequirements.suggestedItemRequirement',
            'poe.subpap.itemRequirements.chartOfAccount',
            'poe.subpap.itemRequirements.procurementMode',
            'poe.subpap.itemRequirements.appForm',
            'poe.creator.division_section',
            'poe.serviceRegion',
            'poe.categoryClass.fundChargeability',
        ])
        ->whereHas('poe.categoryClass', function($q){
            $q->where('ac_id', 1)->orWhere('ac_id', 3);
        })
        ->whereHas('poe', function($q) use($stage_id, $year, $service_region_id){
            $q->where('stage_id', $stage_id)
            ->where('year', $year)
            ->where('service_region_id', $service_region_id);
        });

        if(@$request->app_form_id){
            $app_id = $request->app_form_id;
            $formPpmp = $formPpmp->whereHas('poe.subpap.itemRequirements.appForm', function($q) use($app_id){
                $q->where('app_id', $app_id);
            });
        }

        return $formPpmp->get();
    }
    public function save(Request $request)
    {
        $stage_id = Stage::where('active', '1')->first()->id;
        $appForm = FormApp::where([
            ['year', $request->input('year')],
            ["service_region_id", $request->input('service_region_id'),],
            ['stage_id', $stage_id],
        ])->first();

        if(@!$appForm){
            $appForm = FormApp::create([
                "year"=>$request->input('year'),
                "stage_id"=>$stage_id,
                "service_region_id"=>$request->input('service_region_id'),
                // "status_id"=>1,
            ]);
        }
        foreach ($request->input("rows") as $row) {
            FormAppRow::updateOrCreate([
                "item_req_id"=>$row["item_req_id"],
                "app_id"=>$appForm->id,
            ],[
                "app_procurement_program"=>$row["app_procurement_program"],
                "app_advertisement"=>$row["app_advertisement"],
                "app_contract_signing"=>$row["app_contract_signing"],
                "app_notice_of_award"=>$row["app_notice_of_award"],
                "app_remarks"=>$row["app_remarks"],
                "app_submission"=>$row["app_submission"],
            ]);
        }
    }
    public function list(Request $request)
    {
        $appForm = FormApp::query();
        $stage_count = FormApp::query();
        if (@is_numeric(@$request->filters['stage'])) {
            $appForm = $appForm->where('stage_id', $request->filters['stage']);
        }
        if (@is_numeric(@$request->filters['year'])) {
            $appForm = $appForm->where('year', $request->filters['year']);
            $stage_count = $stage_count->where('year', $request->filters['year']);
        }
        $appForm = $appForm->with('serviceRegion')->paginate(10);
        $stage_count = $stage_count->select(['stage_id', DB::raw("COUNT(1) as row_count")])->groupBy(DB::raw("(stage_id)"))
        ->get()->keyBy('stage_id');

        return [
            "pagination_data" => $appForm,
            "stages" => $stage_count,
        ];
    }
}
