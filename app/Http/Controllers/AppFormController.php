<?php

namespace App\Http\Controllers;

use App\Models\FormApp;
use App\Models\FormAppRow;
use App\Models\FormPpmp;
use App\Models\FundChargeability;
use App\Models\Setting;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppFormController extends Controller
{
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
        return view("pages.form.app-form");
    }
    public function showReport()
    {
        return view("pages.reports.app-form");
    }
    public function create($year)
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
        $appForm = FormApp::where([
            ['year', $year],
            ['stage_id', $stage_id],
        ])->first();

        if(@$appForm){
            return redirect('/form/app-form/edit/'.$appForm->id);
        }
        else{
            return view("pages.form.app-form-create", ["year"=>$year]);
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
            return view("pages.form.app-form-create", ["year"=>$appForm->year]);
        }
        return abort(404);
    }
    public function view($id)
    {
        $appForm = FormApp::find($id);
        if(@$appForm){
            return view("pages.form.app-form-view", ["year"=>$appForm->year, "id"=>$id]);
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

        $formPpmp = FormPpmp::query();
        $formPpmp = $formPpmp->where('funded', '1')
        ->whereYear('created_at', $request->year)
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
        ->whereHas('poe', function($q) use($stage_id){
            $q->where('stage_id', $stage_id);
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
            ['stage_id', $stage_id],
        ])->first();

        if(@!$appForm){
            $appForm = FormApp::create([
                "year"=>$request->input('year'),
                "stage_id"=>$stage_id,
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
        $appForm = $appForm->paginate(10);
        $stage_count = $stage_count->select(['stage_id', DB::raw("COUNT(1) as row_count")])->groupBy(DB::raw("(stage_id)"))
        ->get()->keyBy('stage_id');

        return [
            "pagination_data" => $appForm,
            "stages" => $stage_count,
        ];
    }
}
