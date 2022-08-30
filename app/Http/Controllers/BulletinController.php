<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
class BulletinController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */

    public function manage()
    {
        return (Auth::user()->hasPermissionTo('bulletin-manage-posts-access'))?  view('pages.bulletin.manage-bulletin'):abort(403);
    }

    public function board()
    {
        return (Auth::user()->hasPermissionTo('bulletin-boards-access'))?  view('pages.bulletin.boards'):abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */
}
