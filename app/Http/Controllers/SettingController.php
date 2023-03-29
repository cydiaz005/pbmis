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
use App\Jobs\ChangeStageJob;
use App\Models\User;
use Illuminate\Support\Str;
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
        $stages = Stage::get()->append('next_stage_id')->keyBy('id');
        $active_stage = $stages->where('active', '1')->first();
        $next_stage = $stages[$active_stage->next_stage_id];

        return (Auth::user()->hasPermissionTo('general'))?  
        view('pages.stage-warning',[
            'active_stage' => $active_stage,
            'next_stage' => $next_stage,
            'changing_stage' => Setting::changingStage(),
        ]):
        abort(403);
    }

    public function setActiveStage(Request $request)
    {
        abort_if(!@$request->stage_affetced_year, 403);
        (!(Hash::check($request['password'], Auth::user()->password)))? abort(500, 'Password mismatch'):0;
        ChangeStageJob::dispatch($request->stage_affetced_year);
        Setting::updateOrCreate(["key"=>"changing_stage"],["value"=>1]);
        return;        
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
