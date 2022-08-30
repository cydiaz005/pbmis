<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Actions\Notify\Notify;
use App\Http\Controllers\EmailController;
use Auth;

class PermissionController extends Controller
{
    public function update(Request $request,$role_id)
    {
        if(!Auth::user()->hasPermissionTo('roles-and-permissions-access')){abort(403);}
        //TODO - transfer ha Role Controller
        $request->validate([
            'permissionsToToggle' => 'required',
        ]);

        $role = Role::find($role_id);

        foreach ($request->permissionsToToggle as $key => $permissionToToggle) {
            if($role->hasPermissionTo($permissionToToggle)){
                $role->revokePermissionTo($permissionToToggle);
            }
            else{
                $role->givePermissionTo($permissionToToggle);
            }
        }
        $users = User::whereRelation("rol", function($role){
            $role->where("role_id", 1);
        })->get();
        $reciever = [];
        $receiver_ids = [];
        foreach ($users as  $value) {
            array_push($reciever, $value->email);
            array_push(  $receiver_ids, $value->id);
        }
        Notify::create($receiver_ids, [
            "type" => "user-new-roles",
            "notifiable" => ['App\Models\Role',@$role->id],
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => "Update Roles for <strong>".@$role->name."</strong>",
        ]);
        return response()->json("Role updated");
    }


    public function updateUserPermission(Request $request,$id)
    {
        if(!Auth::user()->hasPermissionTo('special-privileges-access')){abort(403);}
        //TODO - transfer ha Role Controller
        $request->validate([
            'permissionsToToggle' => 'required',
        ]);
        $user = User::find($id);
        $permissionsToToggle = $request->permissionsToToggle;
        $has = [];
        $hasno = [];

        foreach ($permissionsToToggle as $key => $permission) {
            if($user->hasDirectPermission($permission)){
                $user->revokePermissionTo($permission);
                array_push($has,$permission);
            }
            else{
                $user->givePermissionTo($permission);
                array_push($hasno,$permission);
            }
        }
        Notify::create([ @$user->id], [
            "type" => "user-new-roles",
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => "Has Updated Your Special Previledges",
        ]);
        $email = new EmailController();
        $email->sendEmailSpecialPreviledges(
            array(
                "receiver" => @$user->email,
                "subject" => "Special Priviledges has been Updated",
                "priviledges" => $permissionsToToggle
            )
        );

        return response()->json($user->permissions);
    }
}
