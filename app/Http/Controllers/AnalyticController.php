<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AllotmentClass;
use App\Models\FundChargeability;
use App\Models\FundChargeabilityClass;
use App\Models\FundChargeabilityClassAccount;
use App\Models\FiscalLimit;
use App\Models\ServiceRegion;
use App\Models\FormPoe;
use Illuminate\Support\Facades\DB;


class AnalyticController extends Controller
{
    public function budgetAllotmentClass(Request $request)
    {
        $request = $request->validate([
            'office' => 'required',
            'year' => 'required',
        ]);
        
        $service_region = ServiceRegion::where('co', $request['office'])->with('fiscalLimit.category.allotmentClass')->get();
        return response()->json($service_region);
    }

    public function budgetFundChargeabilty(Request $request)
    {
        $request = $request->validate([
            'office' => 'required',
            'year' => 'required',
        ]);
        $service_region = ServiceRegion::where('co', $request['office'])->with('fiscalLimit.category.fundChargeability')->get();
        return response()->json($service_region);

    }
    public function budgetCategory(Request $request)
    {
        $request = $request->validate([
            'office' => 'required',
            'year' => 'required',
        ]);
        $service_region = ServiceRegion::where('co', $request['office'])->with('fiscalLimit.category.allotmentClass', 'fiscalLimit.category.fundChargeability')->get();
        return response()->json($service_region);


    }

    public function budgetServiceRegion(Request $request)
    {
        $current = date('Y');

        $request = $request->validate([
            'region' => 'required',
            'year' => 'required',
        ]);

        $sevice_region = ServiceRegion::where('accronym', $request['region'])->first()->id;
        // $test = FundChargeabilityClass::with('allotmentClass', 'fundChargeability')
        // ->with('fiscalLimit.serviceRegion.poes')
        // ->get();

        // return response()->json($test);
    
        $test = FundChargeabilityClass::whereYear('fund_chargeability_classes.created_at','=',  $current)
        ->join('form_poes','form_poes.category_id', 'fund_chargeability_classes.id')
        ->join('allotment_classes','allotment_classes.id', 'fund_chargeability_classes.ac_id')
        ->join('fund_chargeabilities','fund_chargeabilities.id', 'fund_chargeability_classes.fc_id')
        ->join('fiscal_limits','fiscal_limits.cat_id', 'fund_chargeability_classes.id')
        ->where('form_poes.service_region_id', $sevice_region)
        ->where('form_poes.status_id', 2)
        ->where('fiscal_limits.serreg_id', $sevice_region)
        ->whereYear('form_poes.created_at','=',  $current)
        ->groupBy("form_poes.category_id")
        ->selectRaw('
            form_poes.category_id, 
            allotment_classes.accronym as allotment_class,
            fund_chargeabilities.accronym as fund_chargeability, 
            fiscal_limits.amount as budget, 
            SUM(form_poes.total)as published'
        )
        ->get();

        return response()->json($test);


        // App\User::addSelect(['last_activity' => Activities::select('created_at')
        // ->whereColumn('user_id', 'users.id')
        // ->orderBy('created_at', 'desc')
        // ->limit(1)])
        // ->find(1);

    }
}
