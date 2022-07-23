<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FormOpc;

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
        return (Auth::user()->hasPermissionTo('form-budget-funded-access'))?  view('pages.form.budget-funded'):abort(403);
    }
    
    public function formBudgetUnfunded(){
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
