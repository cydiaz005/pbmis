<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FormOpc;
use App\Models\Setting;

class PageController extends Controller
{   

    
    

    

   

    public function formOpc(){

        return (Auth::user()->hasPermissionTo('form-opc-access'))?  view('pages.form.opc-ops'):abort(403);
    }
    
    public function formTemplate(){
        return (Auth::user()->hasPermissionTo('general'))?  view('pages.form.form-template'):abort(403);
    }
    
    public function formApb1a(){
        return (Auth::user()->hasPermissionTo('form-apb-access'))?  view('pages.form.apb1a'):abort(403);
    }
    
    public function formBudgetFunded(){

        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'Budget Form-Funded', 'route' => '#'],
                ],
                'page_title' => 'Budget Form (Funded)',
                "sidebar_id" => "#li_fundedform",
            ]);
        }
        return (Auth::user()->hasPermissionTo('form-budget-funded-access'))?  view('pages.form.budget-funded'):abort(403);
    }
    
    public function formBudgetUnfunded(){
        $changing_stage = Setting::changingStage();
        if($changing_stage){
            return view('form_not_available', [
                'breadcrumb' => [
                    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                    ['name' => 'Forms', 'route' => '#'],
                    ['name' => 'Budget Form-Unfunded', 'route' => '#'],
                ],
                'page_title' => 'Budget Form (Unfunded)',
                "sidebar_id" => "#li_unfundedform",
            ]);
        }
        return (Auth::user()->hasPermissionTo('form-budget-unfunded-access'))?  view('pages.form.budget-unfunded'):abort(403);
    }
    
    public function formPpmp(){
        return (Auth::user()->hasPermissionTo('form-ppmp-access'))?  view('pages.form.ppmp'):abort(403);
    }
    public function formFiscalCreate(){
        return (Auth::user()->hasPermissionTo('form-working-fiscal-limits-access'))?  view('pages.extras.create-fiscal'):abort(403);
    }
    public function report($year, $region){
        return view('pages.reports.budget');
    }
    



    
    
   



}
