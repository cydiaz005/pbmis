<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class DataGuardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */
    public function rolesPermissions()
    {
        // return (Auth::user()->hasPermissionTo('roles-and-permissions-access'))?  view('pages.roles'):abort(403);    

        return (Auth::user()->hasPermissionTo('roles-and-permissions-access'))?  view('pages.roles'):abort(403);    
    }
    public function specialPriveleges()
    {
        // return (Auth::user()->hasPermissionTo('roles-and-permissions-access'))?  view('pages.roles'):abort(403);    
        return (Auth::user()->hasPermissionTo('special-privileges-access'))?  view('pages.special-privileges'):abort(403);    
    }

    public function editSpecialPrivileges($id)
    {
        // return (Auth::user()->hasPermissionTo('roles-and-permissions-access'))?  view('pages.roles'):abort(403);    
        return (Auth::user()->hasPermissionTo('special-privileges-access'))?  view('pages.special-privileges-edit',['id'=>$id]):abort(403);    
    }
    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */
}
