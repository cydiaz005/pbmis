<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AuditTrailController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | View Section
    |--------------------------------------------------------------------------
    */

    public function index ()
    {
        return (Auth::user()->hasPermissionTo('audit-trail-access'))?  view('pages.activity-log.activity-log'):abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | Backend Section
    |--------------------------------------------------------------------------
    */
}
