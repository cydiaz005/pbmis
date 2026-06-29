<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ServiceRegion;
use App\Models\Image;
use App\Http\Controllers\EmailController;
use App\Models\TemporaryPassword;
use App\Actions\Notify\Notify;
use App\Mail\GeneralMailer;
use App\Models\Notification;
use App\Models\Role as Rol;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Throwable;

class UserController extends Controller
{
    
    public function all()
    {
        return (Auth::user()->hasPermissionTo('users-approval-suspension-access'))?  view('pages.user.all'):abort(403);
    }
    public function superAdmin()
    {
        return (Auth::user()->hasPermissionTo('users-super-administrator-access'))?  view('pages.user.super-admin-user'):abort(403);
    }
    public function admin()
    {
        return (Auth::user()->hasPermissionTo('users-administrator-access'))?  view('pages.user.admin-user'):abort(403);
    }
    public function twg()
    {
        return (Auth::user()->hasPermissionTo('users-technical-working-froup-access'))?  view('pages.user.twg-user'):abort(403);
    }
    public function pfo()
    {
        return (Auth::user()->hasPermissionTo('users-planning-focal-access'))?  view('pages.user.pfo-user'):abort(403);
    }
    public function getSuperAdminAndAdminData()
    {
        return User::whereHas("rol", function($q){
            $q->where("role_id", 1);
            $q->orWhere("role_id",2);
        })->get();
    }
    public function getSuperAdminAndAdminEmailAndId()
    {
        $users = User::whereHas("rol", function($q){
            $q->where("role_id", 1);
            $q->orWhere("role_id",2);
        })->get();
        $email_ids = [
            "emails"=>[],
            "ids"=>[],
        ];
        foreach ($users as $key => $value) {
            array_push($email_ids['emails'], $value->email);
            array_push($email_ids['ids'], $value->id);
        }
        return $email_ids;
    }
    public function changeRole(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('users-approval-suspension-access')){abort(403);}
        $request->validate([
            'roleId' => 'required',
        ]);
        
        $user = User::find($id);
        $user_old_role = $user->rol->role->name;
        $role = Rol::where("id",$request->roleId )->first();

        if(@$role && @$user){

            $super_admin_and_admin_data = $this->getSuperAdminAndAdminData();
            $admin_emails = [];
            $admin_ids = [];
            
            foreach ($super_admin_and_admin_data as $key => $value) {
                array_push( $admin_emails , $value->email);
                array_push( $admin_ids , $value->id);
            }

            array_push($admin_emails , $user->email);
            array_push($admin_ids , $user->id);
            
            Notification::where(
                'receiver_id',$user->id
            )->where('notif_type', "user-role-status")
            ->delete();

            Notify::create($admin_ids, [
                "type" => "user-role-status",
                "notifiable" => ['App\Models\User',$id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" => "changed the role of ".$user->name."'s from <strong>".$user_old_role."</strong> to <strong>".$role->name."</strong>",
            ]);

            Mail::to($admin_emails)->queue(new GeneralMailer([
                "subject" => "User role changed",
                "template_data" => [
                    "email_message" => $user->name."'s role was changed by ".Auth::user()->name." from <strong>".$user_old_role."</strong> to <strong>".$role->name."</strong>",
                    "button"=>[
                        "redirect"=>env('APP_URL')."login",
                        "text"=>"Login now!",
                    ]
                ],
            ]));
        }

        $user->syncRoles([$request->roleId]);
        return response()->json("User Role Updated");
    }
    public function changeStatus(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('users-approval-suspension-access')){abort(403);}
        $request->validate([
            'status' => 'required',
        ]);
        $status = $request->status;
        $user = User::find($id);
        $user->status = $status;

        $status_value = "";

        $email_ids = $this->getSuperAdminAndAdminEmailAndId();

        //APPROVED BY
        if($status==1){
            $status_value = "Approved";
            $user->approver()->associate(Auth::user());
        }

        //IF USER IS SUSPENDED
        if($status==2){
            $status_value = "Suspended";
            $user->syncRoles(['Banned']); //CHANGE ROLE TO BANNED
        }
        //IF USER IS PENDING
        if($status==0){
            $status_value = "Pending";
            $user->syncRoles(['Guest']); //CHANGE ROLE TO BANNED
        }
        $user->save();

        Mail::to($user->email)->send(new GeneralMailer([
            "subject" => "User status changed",
            "template_data" => [
                "email_message" => "Your status was changed by ".Auth::user()->name." to <strong>".$status_value."</strong>",
                "button"=>[
                    "redirect"=>env('APP_URL')."login",
                    "text"=>"Login now!",
                ]
            ],
        ]));

        Mail::to($email_ids['emails'])->send(new GeneralMailer([
            "subject" => "User status changed",
            "template_data" => [
                "email_message" => $user->name."'s status was changed by ".Auth::user()->name." to <strong>".$status_value."</strong>",
                "button"=>[
                    "redirect"=>env('APP_URL')."login",
                    "text"=>"Login now!",
                ]
            ],
        ]));

        Notify::create($email_ids['ids'], [
            "type" => "user-change-status",
            "notifiable" => ['App\Models\User',$user->id],
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => "updated the status of ".$user->name."'s to <strong>".$status_value."</strong>",
        ]);

        Notify::create([$user->id], [
            "type" => "user-change-status",
            "notifiable" => ['App\Models\User',$user->id],
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => "updated your status to <strong>".$status_value."</strong>",
        ]);
        
        return response()->json("User Status Updated");
    }

    public function changeServiceUser(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('users-approval-suspension-access')){abort(403);}
        $request->validate([
            'serreg_id' => 'required',
        ]);

        $user = User::find($id);
        if(!$user){
            return response()->json('User not found', 404);
        }

        $old_service = $user->serreg_id;
        $service = ServiceRegion::find($request->serreg_id);

        if(!$service){
            return response()->json('Service not found', 404);
        }

        $user->serreg_id = $service->id;
        $user->save();

        // notify admins and the user about the change
        $email_ids = $this->getSuperAdminAndAdminEmailAndId();
        $service_name = $service->service_region;

        Notify::create($email_ids['ids'], [
            "type" => "user-change-service",
            "notifiable" => ['App\\Models\\User',$user->id],
            "sender" => ['App\\Models\\User', Auth::user()->id],
            "message" => "changed the service of <strong>".$user->name."</strong> to <strong>".$service_name."</strong>",
        ]);

        Notify::create([$user->id], [
            "type" => "user-change-service",
            "notifiable" => ['App\\Models\\User',$user->id],
            "sender" => ['App\\Models\\User', Auth::user()->id],
            "message" => "updated your service to <strong>".$service_name."</strong>",
        ]);

        Mail::to($email_ids['emails'])->queue(new GeneralMailer([
            "subject" => "User service changed",
            "template_data" => [
                "email_message" => $user->name."'s service was changed by ".Auth::user()->name." to <strong>".$service_name."</strong>",
                "button"=>[
                    "redirect"=>env('APP_URL')."login",
                    "text"=>"Login now!",
                ]
            ],
        ]));

        return response()->json("User Service Updated");
    }

    public function storeAndBoard(Request $request){
       
       try{
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            // 'ext' => 'required',
            'gender' => 'required',
            'divsec_id' => 'required',
            'pos_id' => 'required',
            'serreg_id' => 'required',
        ]);
        $user = User::create($request->all());
        $user->password = Hash::make($request->password);
        $user->assignRole('Guest');
        $user->save();
        $receiver_ids = [];
        if(@$user){
            $temporary = $this->createTemporary($user->id);
            if($temporary){
                $users = User::where("id", '!=',  Auth::user()->id)->whereRelation("rol", function($role){
                    $role->where("role_id", 1);
                    $role->orWhere("role_id",2);
                    $role->orWhere("role_id",6);
                })->get();
               
                foreach ($users as  $value) {      
                    array_push(  $receiver_ids, $value->id);
                }
                Notify::create($receiver_ids, [
                    "type" => "user-new-user",
                    "notifiable" => ['App\Models\User',Auth::user()->id],
                    "sender" => ['App\Models\User', Auth::user()->id],
                    "message" => "Created New User",
                ]);
                $email = new EmailController();
                $email->preRegistration(
                    array(
                        "receiver" =>  $user->email,
                        "user" =>  $user,
                        "subject" => "OCD PBMIS Email Verification ",
                        "token" => $temporary,
                        "password" => $request->password
                    )
                );
            }
         
        }
      
        return back()->with('success', 'User created successfully', $receiver_ids);
       }catch(Throwable $e){
        return back()->with('warning', 'failed to create');
       } 
    }
    public function changeProfilePhoto(Request $request,$id){
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $file = $request->file('image');
        $destinationPath = 'public/images/';
        $originalFile = $file->getClientOriginalName();

        $file->move($destinationPath, $originalFile);
        $user = User::find($id);
        $user->profilePhoto()->updateOrCreate([],['url'=>$originalFile]);

        return back()->with('success', 'User updated successfully');
    }

    public function unverifiedUser(Request $request){
        return  view('pages.user.unverified');
    }

    public function createTemporary($id){
        $tempoary = new TemporaryPassword();
        $tempoary->user_id = $id;
        $tempoary->password = $this->RandomString();
        $tempoary->save();
        if($tempoary){
            return $tempoary->password;
        }
        return null;
    }
    public function verifiedUser( $token){
         $token = TemporaryPassword::where("password", $token)->first();
     
        
        if( $token ){
           
            $user = User::where("id", $token->user_id)->first();
           
            if($user ){
               TemporaryPassword::where("id", $token->id)->delete();
               $verifiedNow = User::find($token->user_id);

               $verifiedNow->email_verified_at = Carbon::now()->toDateTimeString();
               $verifiedNow->update();
                return redirect("");
            }else{
                TemporaryPassword::where("password", $token->id)->delete();
                abort(403);
            }
        }else{
            abort(403);
           
        }
       
    }

    public function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
      
        for ($i = 0; $i < 50; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return  $randomString;;
    }
    public function changeStatusUser($status, $users_emails, $users_id, $user, $user_id){
        $msg = "Updated the Status of <strong>".$user."</strong> to $status";
        Notify::create($users_id, [
            "type" => "user-change-status",
            "notifiable" => ['App\Models\User',$user_id],
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" =>   $msg ,
        ]);
        $email = new EmailController();
        $email->approvalChangeRole(
            array(
                "receiver" => $users_emails,
                "subject" => "Updated Status OCD PBMIS",
                "user" => $user
            )
        );
    }
    public function changeRolesUser(User $user, $old_role, $new_role)
    {
        $super_admin_and_admin_data = $this->getSuperAdminAndAdminData();

        $admin_emails = [];
        $admin_ids = [];
        foreach ($super_admin_and_admin_data as $key => $value) {
           array_push( $admin_emails , $value->email);
           array_push( $admin_ids , $value->id);
        }   
        // Garry's role is changed by Jhepett from Admin to Super Admin.
        $msg = "Updated the Role of <strong>".$user."</strong> to $status";
        Notify::create($users_id, [
            "type" => "user-change-role",
            "notifiable" => ['App\Models\User',$user_id],
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => $msg,
        ]);
        $email = new EmailController();
        $email->approvalChangeRole(
            array(
                "receiver" => $users_emails,
                "subject" => "Updated Status OCD PBMIS",
                "user" => $user
            )
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */

}
