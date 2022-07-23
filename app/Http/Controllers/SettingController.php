<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Stage;
use App\Models\FormPoe;
use App\Models\FormPpmp;
use App\Models\FormPoeSubPap;
use App\Models\FormPoeItemRequirement;
use App\Models\FormPoeItemRequirementMonth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\EmailController;
use App\Actions\Notify\Notify;
use App\Models\User;
class SettingController extends Controller
{
    public function index()
    {
        return (Auth::user()->hasPermissionTo('account-settings-access'))?  view('profile.show'):abort(403);
    }

    public function updateSetting(Request $request)
    {
        return Setting::updateOrCreate(["key"=>$request->key,],["value"=>$request->value]);
    }

    public function stage()
    {
        $stages = Stage::orderBy('active','desc')->get();
        return (Auth::user()->hasPermissionTo('general'))?  
        view('pages.stage-warning',[
            'stages' => $stages 
        ]):
        abort(403);
    }

    public function setActiveStage(Request $request)
    {
        $request = $request->validate([
            'stage' => 'required',
            'password' => 'required',
        ]);


        (!(Hash::check($request['password'], Auth::user()->password)))? abort(500, 'Password mismatch'):0;
  

        $stage = Stage::where('active','1')->first();
        ($stage->id == $request['stage'])? abort(500, 'The stage is still active.'):0;
        $this->rollOutUnpublished($stage->id);
        $poes = FormPoe::where('stage_id', $stage->id)
        ->whereYear('created_at', date('Y'))
        ->with('ppmp','subpap.itemRequirements.itemMonths')
        ->get();

        foreach ($poes as $poe) {
            $new_poe = FormPoe::firstOrCreate([
                "suggested_pap_id" => $poe->suggested_pap_id,
                "creator_id" => $poe->creator_id,
                "pap_txt" => $poe->pap_txt,
                "geolocation" => $poe->geolocation,
                "status_id" => 1,
                "mfo_id" => $poe->mfo_id,
                "key_id" => $poe->key_id,
                "service_region_id" => $poe->service_region_id,
                "category_id" => $poe->category_id,
                "thematic_area_cluster_id" => $poe->thematic_area_cluster_id,
                "stage_id" => $request['stage'],
                "total" => $poe->total,
            ]);

            if(FormPpmp::where('poe_id', $poe->id)->count()){
                FormPpmp::where('poe_id', $poe->id)->delete();
            }

            foreach ($poe->subpap as $subpap) {

                $new_subpap = FormPoeSubPap::firstOrCreate([
                    "poe_id" =>   $new_poe->id,
                    "quarter_target_id" =>   $subpap->quarter_target_id,
                    "subpap_txt" =>   $subpap->subpap_txt,
                    "suggested_subpap_id" =>   $subpap->suggested_subpap_id,
                ]);
                
                foreach ($subpap->itemRequirements as $ir) {
                    # code...
                    $new_item_requirement = FormPoeItemRequirement::firstOrCreate([
                        "subpap_id" => $new_subpap->id,   
                        "account_id" => $ir->account_id,   
                        "itemreq_txt" => $ir->itemreq_txt,   
                        "no_of_days" => $ir->no_of_days,  
                        "per_capita_cost" => $ir->per_capita_cost,   
                        "procurement_mode_id" => $ir->procurement_mode_id,   
                        "qty_pax" => $ir->qty_pax,   
                        "suggested_itemreq_id" => $ir->suggested_itemreq_id,   
                        "total" => $ir->total,   
                        "unit" => $ir->unit,   
                        "unit_id" => $ir->unit_id,   
                    ]);

                    foreach ($ir->itemMonths as $item) {
                       $item_req_month = FormPoeItemRequirementMonth::firstOrCreate([
                            "item_req_id" => $new_item_requirement->id,
                            "amount" => $item->amount,
                            "month" => $item->month,
                            "qty" => $item->qty,
                        ]);;
                    };
                }
            }

        }
        $users = User::where('id', '!=', Auth::user()->id)
                    ->where("status", '!=','0' )
                    ->where('email_verified_at', '!=',null)->get();

        $recieverIds = [];
        $recieverEmail = [];
        foreach ($users as $user) {
          array_push($recieverIds, $user->id);
          array_push($recieverEmail, $user->email);
        }
        if($stage){
            Notify::create($recieverIds,  [
                "type" => "user-create-poe",
                "notifiable" => ['App\Models\Stage', $stage->id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "Fiscal Stage has been Updated",
            ]);
            $email = new EmailController();
            $email->fiscalStage(
                array(
                    "subject" => "Fiscal Stage Updated",
                    "receiver" => $recieverEmail
                )
            );
        }
        
        abort(200);
        
    }
    public function rollOutUnpublished($stage_id)
    {        

        $unpub_ppmps = FormPpmp::where('funded',  null)
        ->whereYear('created_at', date('Y'))
        ->delete();

        FormPpmp::truncate();

        $unpub_poes = FormPoe::where('stage_id', '!=', $stage_id)
        ->whereYear('created_at', date('Y'))
        ->with('ppmp','subpap.itemRequirements')
        ->where('status_id','2')
        ->delete();
    }
    public function dueToday()
    {
        $dueNow = Setting::where("key", "classification_end_date")->first();
        if(@$dueNow->value){
            $parse = Carbon::parse(@$dueNow->value)->toDateString();
            $now = Carbon::now()->toDateString();
            if($parse ==  $now){
                $users = User::whereRelation("rol", function($role){
                    $role->where("role_id", 3);
                });
                $receiver_ids = [];
                $receiver_email = [];
                foreach ($users as $key => $user) {
                  array_push($receiver_email, $user->email);
                  array_push($receiver_ids, $user->id);
                }
                // Notify::create($receiver_ids, [
                //     "type" =>"user-due-ppmpClassification",            
                //     "sender" => ['App\Models\User', Auth::user()->id],
                //     "message" => "PPMP CLassification Due Today",
                // ]);
            }
        }
                    
    }
}
