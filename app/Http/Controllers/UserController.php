<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Image;
use App\Http\Controllers\EmailController;
use App\Models\TemporaryPassword;
use App\Actions\Notify\Notify;
use App\Models\Notification;
use App\Models\Role as Rol;
use Carbon\Carbon;
use Throwable;

class UserController extends Controller
{
    
    public function all(){
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
    public function changeRole(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('users-approval-suspension-access')){abort(403);}
        $request->validate([
            'roleId' => 'required',
        ]);
        $user = User::find($id);
        $role = Rol::where("id",$request->roleId )->first();
        $users = User::whereRelation("rol", function($role){
            $role->where("role_id", 1);
            $role->orWhere("role_id",2);
            $role->orWhere("role_id",6);
        })->get();
        $users_email = [];
        $users_id = [];
        foreach ($users as $key => $value) {
           array_push( $users_email , $value->email);
           array_push( $users_id , $value->id);
        }
        if($role){
            Notification::where(
                'receiver_id',$id
                
            )->where('notif_type', "user-role-status")->delete();
            Notify::create([$id], [
                "type" => "user-role-status",
                "notifiable" => ['App\Models\User',$id],
                "sender" => ['App\Models\User', Auth::user()->id],
                "message" =>   "Has Change Role to <strong>".$role->name."</strong>" ,
            ]);
            $this->changeRolesUser($role->name, $user->email, $users_id, "".$user->firstname." ".$user->lastname, $user->id);
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
        $users = User::whereRelation("rol", function($role){
            $role->where("role_id", 1);
            $role->orWhere("role_id",2);
            $role->orWhere("role_id",6);
        })->get();
        $users_email = [];
        $users_id = [];
        foreach ($users as $key => $value) {
           array_push( $users_email , $value->email);
           array_push( $users_id , $value->id);
        }
        //APPROVED BY
        if($status==1){
            $user->approver()->associate(Auth::user());
            $this->changeStatusUser("Approved", $user->email, $users_id, "".$user->firstname." ".$user->lastname,  $user->id );
        }

        //IF USER IS SUSPENDED
        if($status==2){
            $user->syncRoles(['Banned']); //CHANGE ROLE TO BANNED
            $this->changeStatusUser("Suspended",$user->email, $users_id, "".$user->firstname." ".$user->lastname,  $user->id );
        }
        //IF USER IS PENDING
         if($status==0){
            $user->syncRoles(['Guest']); //CHANGE ROLE TO BANNED
            $this->changeStatusUser("PENDING",$user->email, $users_id, "".$user->firstname." ".$user->lastname, $user->id );
        }

        $user->save();
        return response()->json("User Status Updated");
    }

    public function storeAndBoard(Request $request){
       
       try{
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'ext' => 'required',
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
    public function changeRolesUser($status, $users_emails, $users_id, $user, $user_id)
    {
        $msg = "Updated the Role of <strong>".$user."</strong> to $status";
        Notify::create($users_id, [
            "type" => "user-change-role",
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
    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */

}
