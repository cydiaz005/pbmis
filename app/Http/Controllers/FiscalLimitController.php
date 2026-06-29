<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AllotmentClass;
use App\Models\FiscalLimit;
use App\Models\ServiceRegion;
use App\Models\Stage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\EmailController;
use App\Actions\Notify\Notify;
use App\Models\FundChargeability;
use App\Models\FundChargeabilityClass;
use App\Models\Setting;
use Livewire\Livewire;

class FiscalLimitController extends Controller
{

    public $categories;
    public $category_codes;
    public $service_regions;
    public $regional_offices;
    public $central_offices;
    public $data_entry;
    public $test;

    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'Working Fiscal Limits', 'route' => '#'],
                ],
                'page_title' => 'Working Fiscal Limits',
                "sidebar_id" => "#li_fiscal",
            ]);
        }
        $stage_id = Stage::where('active', '1')->first()->id;
        $excluded_years = FiscalLimit::where('stage_id', $stage_id)->select('year')->groupBy('year')->pluck('year')->toArray();
        
        $years_for_create = [];
        for($i = date("Y"); $i <= (date("Y") + 6); $i++){
            if(!in_array($i, $excluded_years))
            array_push($years_for_create, $i);
        }
        
        return view('pages.form.fiscal-limits',[
            'years_for_create' => $years_for_create,
        ]);
    }

    
    public function fiscalLimitReport()
    {
        
        return view('pages/reports/fiscal-limits');
    }

    public function getReport($stage, $year){
        // request()->route()->setParameter([
        //     'stage' => $stage,
        //     'year' => $year,
        // ]);
        // return Livewire::mount('reports.views.fiscal-limit-form-view',[
        //     'stage' => $stage,
        //     'year' => $year,
        // ])->html();

        return view('pages/reports/fiscal-limits-view',[
            'stage' => $stage,
            'year' => $year,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */

    
    public function create(Request $request)
    {
        if(!@$request->fiscal_year || @$request->fiscal_year < date('Y') || @$request->fiscal_year > (date('Y') + 3)) abort(404);
        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'Working Fiscal Limits', 'route' => '#'],
                ],
                'page_title' => 'Working Fiscal Limits',
                "sidebar_id" => "#li_fiscal",
            ]);
        }

        if($request->routeIs('fiscal-limit.create')){
            $stage_id = Stage::where('active', '1')->first()->id;
            if(FiscalLimit::where([['year', $request->fiscal_year],['stage_id', $stage_id],])->exists()){
                return redirect()->route('fiscal-limit.modify', ['fiscal_year'=>$request->fiscal_year]);
            }
        }
        else if($request->routeIs('fiscal-limit.modify')){
            $stage_id = Stage::where('active', '1')->first()->id;
            if(!FiscalLimit::where([['year', $request->fiscal_year],['stage_id', $stage_id],])->exists()){
                abort(404);
            }
        }
        
        
        $this->categories =  AllotmentClass::with('fundChargeabilityClass.fundChargeability')->orderBy('created_at', 'desc')->get();
        $this->service_regions =  ServiceRegion::get();
        $this->getCategoryCode();
        $this->getOffices();
        $this->setDataEntry();

        return (Auth::user()->hasPermissionTo('form-working-fiscal-limits-access'))?  
        view('pages.extras.create-fiscal2',[
            'categories'=> $this->categories,
            'category_codes' => $this->category_codes,
            'service_regions' => $this->service_regions,
            'regional_offices' => $this->regional_offices,
            'central_offices' => $this->central_offices,
            'data_entry' => $this->data_entry,
            'fiscal_year' => $request->fiscal_year,
        ]):
        abort(403);
    }

    public function getCategoryCode()
    {
        $this->category_codes = [];
        foreach ($this->categories as $allotment_class) {
            foreach ($allotment_class->fundChargeabilityClass as $class) {
                $allotment_class_code = $allotment_class->accronym;
                $fund_chargeability_code = $class->fundChargeability->accronym;
                $category_code = $allotment_class_code.'-'.$fund_chargeability_code;
                array_push($this->category_codes, $category_code);
            }
        }
    }
    public function getOffices()
    {
        $this->regional_offices = [];
        $this->central_offices = [];
        foreach ($this->service_regions as $office) {
            if ($office->co == 0) {
                array_push($this->regional_offices, $office);
            }
            else if ($office->co == 1) {
                array_push($this->central_offices, $office);
            }
        }
    }

    public function setDataEntry()
    {
        $this->data_entry=[];

        foreach ($this->regional_offices as $ro) {
            $index  = $ro->accronym;
            foreach ($this->category_codes as $cc) {
                $key = $ro->accronym.'-'.$cc;
                $this->data_entry['ro'][$index][$key] = null;
            }
            $this->data_entry['ro'][$index][$ro->accronym.'-TOTAL'] = null;   
        }

        foreach ($this->central_offices as $co) {
            $index  = $co->accronym;
            foreach ($this->category_codes as $cc) {
                $key = $co->accronym.'-'.$cc;
                $this->data_entry['co'][$index][$key] = null;
            }
            $this->data_entry['co'][$index][$co->accronym.'-TOTAL'] = null;   
        }

        // dd($this->data_entry);
    }

    public function save(Request $request)
    {
        // $keys = get_object_vars($request);
        $request = $request->validate([
            'data_entry' => 'required',
            'year' => 'required',
        ]);
        $entries = $request['data_entry'];
        $offices = array_keys($entries);

        
        foreach ($offices as $office) {
            # code...
            $budget = $entries[$office];
            $classes = array_keys($budget);
            $sr_id = ServiceRegion::where('accronym', $office)->first()->id;

            foreach ($classes as $class) {
                $stage_id = Stage::where('active','1')->first()->id;
                $fiscal_limit = FiscalLimit::updateOrCreate(
                    [
                        'year' => $request['year'],
                        'cat_id' => $class,
                        'stage_id' => $stage_id,
                        'serreg_id' => $sr_id,
                    ],
                    [
                        'amount' => $budget[$class]
                    ]
                );
            }


        }
        $receiver_ids = [];
        $users = User::where("id", '!=',  Auth::user()->id)->whereRelation("rol", function($role){
            $role->where("role_id", 1);
            $role->orWhere("role_id",2);
            $role->orWhere("role_id",6);
            $role->orWhere("role_id",3);
        })->get();
        foreach ($users as  $value) {      
            array_push(  $receiver_ids, $value->id);
        }
        $stage_id = Stage::where('active','1')->first();
        if( $stage_id){
            Notify::create($receiver_ids, [
                "type" => "user-update-working-fiscal-limit",
                "notifiable" => ['App\Models\Stage',$stage_id->id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => " has updated the working fiscal limit",
            ]);
            $email = new EmailController();
            // $email->forms(
            //     array()
            // );
        }

      
        return response()->json($entries);
    }

    public function edit(Request $request)
    {
        $request = $request->validate([
            'year' => 'required',
        ]);
        $fiscal_year = FiscalLimit::where('year', $request['year'])
        ->get();

        return response()->json($fiscal_year);
    }
    public function getFiscalLimit(Request $request)
    {
        // return $request->all();
        $filters = $request->filters;
        if(Auth::user()->hasRole(['Planning Focal/Officer'])){
            $filters['service_region'] = Auth::user()->serreg_id;
        }

        $fiscal = FiscalLimit::query();

        $fiscal = $fiscal->where('year', '=',$filters['year']); 
        $fiscal = $fiscal->where('stage_id', $filters['stage']); 

        if (@is_numeric(@$filters['service_region'])) {
            $fiscal = $fiscal->where('serreg_id', $filters['service_region']); 
        }

        $fiscal = $fiscal->select(['id', 'stage_id', 'year', 'created_at', 'updated_at', DB::raw('SUM(amount) as budget')]);

        $fiscal = $fiscal->groupBy('stage_id');
        $fiscal = $fiscal->paginate(10);
        $fiscal->append(['formatted_created_at','formatted_created_at']);
        return $fiscal;
    }
    public function delete(Request $request)
    {
       return FiscalLimit::where('year', $request->year)->where('stage_id', $request->stage_id)->delete();
    }
    public function fetch(Request $request)
    {
        $body = FiscalLimit::where('stage_id', $request->stage_id)
        ->where('year', $request->year)
        ->with(['serviceRegion','category.allotmentClass','category.fundChargeability'])
        ->orderBy('serreg_id')
        ->get()->groupBy(['serviceRegion.office_id','serviceRegion.id','category.ac_id','category.fc_id']);

        $header = FundChargeabilityClass::has('fiscalLimit')->get()->groupBy(['ac_id','fc_id']);
        $fc = FundChargeability::all()->keyBy('id');
        $ac = AllotmentClass::all()->keyBy('id');
        $service_regions = ServiceRegion::all()->keyBy('id');

        return [
            'header'=>$header,
            'body'=>$body,
            'ac'=>$ac,
            'fc'=>$fc,
            'service_regions'=>$service_regions,
        ];
    }
}
