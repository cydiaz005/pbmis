<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourceAccount;
use App\Models\Resources;
use App\Models\Role;
use Auth;
use App\Models\ResourceAccess;
class ResourceAccountController extends Controller
{   
    public function viewResourceAccount(Request $request){
        $roles = Role::where([
            ["id", "!=", 5],
            ["id", "!=", 6],
            ["id", "!=", 7]
        ])->get();
        return view("pages.resource.resource_accounts", ["roles" => $roles]);
    }
    public function viewDocument(Request $request){
        return view("pages.resource.resource_doc");
    }
    public function viewVideos(Request $request){
        return view("pages.resource.resouce_vid");
    }
    public function searchResourceAccount(Request $request){
        $query = $request->input("query");
        $except = $request->input("except");
        $user = @Auth::user()->roles->first();

        $resource =  ResourceAccount::query();
        $resource =   $resource->whereNotIn("id", $except)->where("username", "like", "%". $query."%");
        if($user){
            if($user->id == 1){
                return $resource->limit(15)->get();
            }else {
                return  $resource->where("role_id",$user->id )->limit(15)->get();
            }
        }
        return $resource->limit(15)->get();

    }
    public function createResourceAccount(Request $request){
        $username = $request->input("username");
        $password = $request->input("password"); 
        $role = $request->input("role");
        $usernameExist = ResourceAccount::where("username", $username )->first();
        if( $usernameExist){
            return response("Username Already Exist",500 );
        }
        $resouce = new ResourceAccount();
        $resouce->username =  $username;
        $resouce->password  = $password;
        $resouce->role_id = $role;
        $resouce->creator_id = Auth::user()->id;
        $resouce->save();
        return response("Username Already Exist",200 );
    }
    public function updateResourceAccount(Request $request){
        $id = $request->input("id");
        $username = $request->input("username");
        $password = $request->input("password"); 
        $usernameExist = ResourceAccount::where([
            ["username", $username ],
            ['id', '!=',  $id ]
        ])->first();
        if( $usernameExist){
            return response("Username Already Exist",500 );
        }
        $resouce =  ResourceAccount::find($id);
        $resouce->username =  $username;
        $resouce->password  = $password;
        $resouce->update();
        return response("Username Already Exist",200 );
    }
    public function deleteResourceAccount(Request $request){
        ResourceAccount::where("id", $request->input("id") )->delete();
    }

    public function createResource(Request $request){
        $status = $request->input("status");
        $title = $request->input("title");
        $description = $request->input("description");
        $link = $request->input("link");
        $resource_account = $request->input('resource_account');
        $resources = new Resources();
        $resources->status =  $status;
        $resources->title =  $title;
        $resources->description =  $description;
        $resources->link =  $link;
        $resources->save();

        foreach ($resource_account as $key => $value) {
            $access = new ResourceAccess();
            $access->resource_id = $resources->id;
            $access->access_id = $value;
            $access->save();
        }
      
        return;
    }
    public function updateResource(Request $request){
        $status = $request->input("status");
        $title = $request->input("title");
        $description = $request->input("description");
        $link = $request->input("link");   
        $resource_ids = $request->input("resource_ids");
        $resourcesx = Resources::find($request->id);
        $resourcesx->status =  $status;
        $resourcesx->title =  $title;
        $resourcesx->description =  $description;
        $resourcesx->link =  $link;
        $resourcesx->update();

        if($resourcesx){
            foreach ($resource_ids as $key => $value) {
                $isExist = ResourceAccess::where("resource_id",$request->id)
                            ->where("access_id",$value )->first();
                if(!$isExist){
                    $access = new ResourceAccess();
                    $access->resource_id = $request->id;
                    $access->access_id = $value;
                    $access->save();
                }
              
            }
        }
        ResourceAccess::where("resource_id", $request->id)->whereNotIn("access_id",$resource_ids )->delete();
       return;
    }
    public function deleteResource(Request $request){
        Resources::where("id", $request->input("id") )->delete();
        return;
    }
}
