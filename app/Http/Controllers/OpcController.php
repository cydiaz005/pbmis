<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormPpmp;
use App\Models\FormOpcItem;
use App\Models\FormOpc;
use App\Models\PerformanceMeasures;
use App\Models\PerformanceTargets;
use App\Models\ReturnedForm;
use App\Models\ServiceRegion;
use App\Http\Controllers\Toastr;
use Auth;
use Crypt;
use Carbon\Carbon;

use App\Models\Mfo;
use App\Models\PriorityClass;

class OpcController extends Controller
{

    public function report()
    {
       return view();
    }





    public function fetchOneOpc($id,$export=''){
        $pms = PerformanceMeasures::all();
        $opcItems = FormOpcItem::where("form_opc_id",$id)->with(['mfo','performanceMeasures'])->get()->groupBy(["pc_id"]);
        $opc = FormOpc::where('id',$id)->first();
        return view('pages.form.opc-one')->withOpc($opc)->withOpcItems($opcItems)->withPms($pms)->withId($id)->with(['export'=>$export,'fname'=>$opc]);
    }
    public function getData(Request $request){
        $pms = PerformanceMeasures::all();
        $pcs = PriorityClass::all()->keyBy('id');
        $opcItems = FormOpcItem::where("form_opc_id",$request->id)->with(['mfo','performanceMeasures'])->get()->groupBy(["pc_id"]);
        $opc = FormOpc::where('id',$request->id)->first();
        return [
            "performance_measures"=>$pms,
            "priority_classes"=>$pcs,
            "opc_items"=>$opcItems,
            "opc"=>$opc,
        ];
    }

    public function storeForm(Request $request,$parameter){

        $data = $request->data;
        $year = $request->year;


        // dd($semester);
        $form_opc = new FormOpc;

        $form_opc->creator_id = Auth::user()->id;
        $form_opc->serreg_id = Auth::user()->serreg_id;
        $form_opc->semester = $request->semester;
        $form_opc->year = $request->year;
        $form_opc->add_point_score = $request->add_point_score;
        $form_opc->save();
        foreach ($data as $mfo_id => $body) {
            $form_opc_item = new FormOpcItem;
            $form_opc_item->success_indicator_mt = $body['success_indicator_mt'];
            $form_opc_item->ps_outstanding = $body['ps_outstanding'];;
            $form_opc_item->ps_very_satisfactory = $body['ps_very_satisfactory'];
            $form_opc_item->ps_satisfactory = $body['ps_satisfactory'];
            $form_opc_item->ps_unsatisfactory = $body['ps_unsatisfactory'];
            $form_opc_item->ps_poor = $body['ps_poor'];
            $form_opc_item->division_accountable = $body['division_accountable'];
            $form_opc_item->actual_accomplishments = $body['actual_accomplishments'];
            $form_opc_item->remarks = $body['remarks'];
            $form_opc_item->pc_id = $body['pc_id'];
            // $form_opc_item->fc_id = $body['fc_id'];
            $form_opc_item->mfo_id = $mfo_id;


            $form_opc->formOpcItems()->save($form_opc_item);


            foreach ($body['performance_measures'] as $pm_id => $data) {
                $form_opc_item->performanceMeasures()->attach([$pm_id=>['rating'=>$data['rating'],'target'=>$data['target']]]);
            }
            // $pts = [];
            // foreach ($body['performance_targets'] as $pt) {
            //     if(isset($pt)){
            //         $performance_target = new PerformanceTargets(['name'=>$pt]);
            //         array_push($pts,$performance_target);
            //     }

            // }
            // if(count($pts)>0)
            // {
            //     $form_opc_item->performanceTargets()->saveMany($pts);
            // }




        }
        // return redirect('/form/opc')->with('success', 'Successfully created an OPC Form.');
        return redirect()->back();

    }

    public function create($parameter)
    {
        if(!Auth::user()->hasPermissionTo('forms-access')){abort(403);}

        try {
            $decrypted_parameter= Crypt::decrypt($parameter);
            $serreg_id = Auth::user()->serreg_id;
            // $serreg_id = 18;

            // $mfos = Mfo::whereRelation('offices',function($officeq) use($serreg_id){
            //     $officeq->whereRelation('serviceRegions',function ($sq) use($serreg_id) {
            //         $sq->where('id',$serreg_id);
            //     });
            // })->with(['poes'])->get()->groupBy(['pc_id']);
            // return $mfos;

            $mfos = Mfo::whereHas('offices.serviceRegions',function($officeq) use($serreg_id){
                $officeq->where('id',$serreg_id);
            })->with(['poes'])->get()->groupBy(['pc_id']);

            // return $mfos;
            $pms = PerformanceMeasures::all();

            // $ppmps = FormPpmp::
            // // whereDate('updated_at','>=',$decrypted_parameter['from_date'])
            // // ->whereDate('updated_at','<=',$decrypted_parameter['to_date'])
            // whereRelation('poe',function($q) use ($serreg_id) {
            //     // $q->where("service_region_id",$serreg_id);
            // })
            // // ->whereRelation('poe.mfo',function($q) use ($serreg_id) {
            // //     $q->selectRaw('SUM(poe.mfo.total) as total_mfo');
            // // })
            // ->with(
            //     [
            //         'poe',
            //         'poe.mfo.priorityClass',
            //         'poe.mfo.poes',
            //     ])
            //     ->get()
            //     ->sortBy('poe.mfo.order')
            // ->groupBy([
            //     'poe.mfo.pc_id',
            // ]);

            return view('pages.form.opc-create',$decrypted_parameter)->withMfos($mfos)->withPms($pms);
        } catch (DecryptException $e) {
            abort(404);
        }
    }
    public function initCreate(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('forms-access')){abort(403);}
        // if(!@$request->input('from_date') || !@$request->input('to_date')){
        //     abort(404);
        // }
        $serreg_id = Auth::user()->serreg_id;

        $request->validate([
            // 'from_date' => 'required',
            // 'to_date' => 'required',
            'semester'=>'required',
            'year'=>'required'
        ]);

        $year = $request->year;
        $semester = $request->semester;

        // $found = FormOpc::where('year',$year)->where('semester',$semester)->where('serreg_id',$serreg_id)->first();
        // if($found){
        //     return redirect()->back()->with('error','OPC/OPS Form already exists!');
        // }
        // $from_date = new Carbon($request->to_date);
        // $to_date = new Carbon($request->from_date);
        // $semester = new Carbon($request->semester);

        // $diff = $to_date->diffInDays($from_date,false);
        // if($diff>365){
        //   return back()->withErrors(['msg' => 'Date error.']);
        // }
        // if($diff<0){
        //   return back()->withErrors(['msg' => 'Date error.']);

        // }
        $parameter=[
            // "from_date"=>$request->from_date,
            // "to_date"=>$request->to_date,
            "semester"=>$request->semester,
            "year"=>$request->year,
        ];
        $encrypted_parameter= Crypt::encrypt($parameter);
        return redirect('form/opc/create/'.$encrypted_parameter);
    }
    public function fetchGroupedPpmp(Request $request)
    {
        $serreg_id = Auth::user()->serreg_id;
        $ppmps = FormPpmp::whereDate('updated_at','>=',$request->from_date)->whereDate('updated_at','<=',$request->to_date)
        ->whereRelation("poe", function($q) use ($serreg_id){
            $q->where("service_region_id", $serreg_id);
        })
        ->with(['poe','poe.mfo.priorityClass', 'poe.categoryClass.fundChargeability'])->get()->groupBy(['poe.mfo.pc_id', 'poe.categoryClass.fundChargeability.id']);
        return $ppmps;
    }

    public function editOpc($id){
        $pms = PerformanceMeasures::all();
        $opcItems = FormOpcItem::where("form_opc_id",$id)->with(['mfo','performanceMeasures'])->get()->groupBy(["pc_id"]);
        $opc = FormOpc::where('id',$id)->first();
        if($opc->locked==true && $opc->locker_user_id != Auth::user()->id){
            return redirect('/form/opc');
        }
        $opc->locked = true;
        $opc->locker_user_id = Auth::user()->id;
        $opc->save();
        return view('pages.form.opc-edit')->withOpc($opc)->withOpcItems($opcItems)->withPms($pms)->withId($id);
    }
    public function updateOpc(Request $request,$id){

        $opcItems = $request->data;
        foreach ($opcItems as $opcId => $body) {
            $form_opc_item = FormOpcItem::find($opcId);
            $form_opc_item->success_indicator_mt = $body['success_indicator_mt'];
            $form_opc_item->ps_outstanding = $body['ps_outstanding'];;
            $form_opc_item->ps_very_satisfactory = $body['ps_very_satisfactory'];
            $form_opc_item->ps_satisfactory = $body['ps_satisfactory'];
            $form_opc_item->ps_unsatisfactory = $body['ps_unsatisfactory'];
            $form_opc_item->ps_poor = $body['ps_poor'];
            $form_opc_item->division_accountable = $body['division_accountable'];
            $form_opc_item->actual_accomplishments = $body['actual_accomplishments'];
            $form_opc_item->remarks = $body['remarks'];

            $form_opc_item->save();

            if(isset($body['performance_measures'])){
                foreach ($body['performance_measures'] as $pm_id => $data) {
                    $form_opc_item->performanceMeasures()->detach($pm_id);
                    $form_opc_item->performanceMeasures()->attach([$pm_id=>['rating'=>$data['rating'],'target'=>$data['target']]]);
                }
            }
        }
        $form_opc = FormOpc::find($id);
        $form_opc->add_point_score = $request->add_point_score;
        $form_opc->locked = false;
        $form_opc->save();
        return redirect('/form/opc')->with('success', 'Successfully updated an OPC Form.');



    }

    public function unlockOpc($id){
        $form_opc = FormOpc::find($id);
        $form_opc->locked = 0;
        $form_opc->locker_user_id = null;
        $form_opc->save();
        return redirect('/form/opc')->with('success', 'Successfully unlocked OPC/OPS.');


    }
    public function publishOpc($id){
        $form_opc = FormOpc::find($id);
        $form_opc->status_id = 2;
        $form_opc->save();
        return [];
        return redirect('/form/opc')->with('success', 'Successfully unlocked OPC/OPS.');
    }

    public function changeStatus(Request $request,$id){
        $form_opc = FormOpc::find($id);
        $form_opc->status_id = $request->status_id;
        $form_opc->save();
        return [];
        return redirect('/form/opc')->with('success', 'Successfully unlocked OPC/OPS.');
    }
    public function deleteOpc($id){

        FormOpc::destroy($id);
        return [];
        // return redirect('form/opc');
    }

    public function return(Request $request)
    {
        $opc_id = $request->input('opc_id');
        $reason = $request->input('reason');

        FormOpc::where('id', $opc_id)->update(['status_id'=>4]);
        return ReturnedForm::create([
            "reason"=>$reason,
            "returner_id"=>Auth::user()->id,
            "returnable_id"=>$opc_id,
            "returnable_type"=>"App\Models\FormOpc",
        ]);
    }

    public function getOpc(Request $request)
    {
        $filters = $request->filters;

        $formOpc = FormOpc::query();

        if($request->status != 0){
            $formOpc = $formOpc->where('status_id', $request->status);
        }

        $formOpc = $formOpc->with(['serviceRegion', 'returnable', 'returnable.returner']);

        if(@is_numeric(@$filters['semester'])){
            $formOpc = $formOpc->where('semester', $filters['semester']);
        }
        if(@is_numeric(@$filters['service_region'])){
            $formOpc = $formOpc->where('serreg_id', $filters['service_region']);
        }
        if(@is_numeric(@$filters['year'])){
            $formOpc = $formOpc->where('year', $filters['year']);
        }

        $formOpc = $formOpc->orderBy('id', 'desc')
        ->paginate(10);

        $formOpc->append(['formatted_created_at', 'formatted_updated_at']);

        return $formOpc;

    }
    public function lockUnlock(Request $request)
    {
        $opc = FormOpc::find($request->input('id'));
        if($opc->locked == '0'){
            $opc->locked='1';
            $opc->locker_user_id=Auth::user()->id;
            $opc->datetime_locked=Carbon::now()->addHours(5);
        }
        else{
            $opc->locked='0';
            $opc->locker_user_id=null;
            $opc->datetime_locked=null;
        }
        $opc->update();
        return $opc;
    }
    public function opc_table(Request $request)
    {
        return view('excel_templates.opc',[
            'year' =>2022,
            'stage' => 1,
        ])->render();
    }
}
