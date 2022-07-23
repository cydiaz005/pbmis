<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\EmailController;
use App\Models\User;
use App\Actions\Notify\Notify;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('roles-and-permissions-access')){abort(403);}
        $request->validate([
            'rolename' => 'required',
        ]);
        $role = Role::firstOrCreate(['name' => $request->rolename,"guard_name"=>'web']);
        
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
            "message" => "have Successfully Created Role <strong>".$request->rolename."</strong>",
        ]);

        return redirect('data-guard/roles-permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->hasPermissionTo('roles-and-permissions-access')){abort(403);}

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('roles-and-permissions-access')){abort(403);}

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('roles-and-permissions-access')){abort(403);}

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('roles-and-permissions-access')){abort(403);}
        $role = Role::where('id', $id);
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
            "type" => "user-delete-roles",
            "sender" => ['App\Models\User', Auth::user()->id],
            "message" => "Roles Has Been Deleted",
        ]);
        // $email = new EmailController();
        // $email->rolesAndPermission(
        //     array(
        //         "subject" => "Roles Has Been Deleted",
        //         "receiver" => $reciever,
        //         "role" =>  $role->first() ,
        //         "creator" => Auth::user(),
        //         "message" => "Roles Has Been Deleted By <strong>".(Auth::user()->firstname." ".Auth::user()->lastname )."</strong>"
        //     )
        // );
        return  $role->delete();

    }
}
