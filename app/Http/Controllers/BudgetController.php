<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\FundChargeabilityClass;
use App\Models\FundChargeabilityClassAccount;
use App\Models\TargetSector;
use App\Models\ListOfSubPap;
use App\Models\ListOfPap;
use App\Models\PapTag;
use App\Models\Units;
use App\Models\Mfo;
use App\Models\MfoKey;
use App\Models\KdpKpKs;
use App\Models\ServiceRegion;
use App\Models\ProcurementMode;
use App\Models\ListOfItemRequirement;
use App\Models\FormPoeItemRequirementMonth;
use App\Models\FormPoeTargetSector;
use App\Models\FormPoe;
use App\Models\FormPpmp;
use App\Models\FormPoeItemRequirement;
use App\Models\FormPoeSubPap;
use App\Models\FormPoeTag;
use App\Models\ThematicAreasCluster;
use App\Models\QuarterTarget;
use App\Models\ReturnedForm;
use Carbon\Carbon;
use DB;

class BudgetController extends Controller
{
    public function fundedList()
    {

    }

    public function listFundedBudget(Type $var = null)
    {
        $ppmp = FormPpmp::select(DB::raw('count(id) as `ppmp_count`'), DB::raw('YEAR(created_at) year'))
        ->whereYear('created_at','=', date('Y'))
        ->where('funded', 1)
        ->groupby('year')
        ->get();
        return view('pages/reports/budget-funded',['ppmp' => $ppmp]);
    }

    public function listUnfundedBudget(Type $var = null)
    {
        $ppmp = FormPpmp::select(DB::raw('count(id) as `ppmp_count`'), DB::raw('YEAR(created_at) year'))
        ->whereYear('created_at','=', date('Y'))
        ->where('funded', 0)
        ->groupby('year')
        ->get();
        return view('pages/reports/budget-unfunded',['ppmp' => $ppmp]);
    }

    public function viewFundedBudget($fiscal_year)
    {
        ($fiscal_year > date('Y') || $fiscal_year < 2022)? abort(404):false;
        return view('pages/reports/budget-funded-view',['fiscal_year' => $fiscal_year]);

    }

    public function viewUnfundedBudget($fiscal_year)
    {
        ($fiscal_year > date('Y') || $fiscal_year < 2022)? abort(404):false;
        return view('pages/reports/budget-unfunded-view',['fiscal_year' => $fiscal_year]);

    }

    public function fiscalBudget(Request $request)
    {
        $request = $request->validate([
            'year' => 'required',
            'funded' => 'required',
        ]);

        $ppmp = FormPpmp::whereYear('created_at','=', $request['year'])
        ->where('funded', $request['funded'])
        ->with(
            'poe.category',
            'poe.categoryClass',
            'poe.creator',
            'poe.userLocker',
            'poe.serviceRegion',
            'poe.suggestedPap',
            'poe.targetSectors',
            'poe.mfo',
            'poe.kdp',
            'poe.thematicAreaCluster',
            'poe.poeTags',
        )
        ->get();
        return response()->json($ppmp);
    }
    public function budget_funded(Request $request)
    {
//        return view('excel_templates.budget-funded',[
//            'year' =>2022,
//            'serreg_id' => 16,
//            'funded_status' => 1
//        ]);
        return view('excel_templates.budget-funded',[
            'year' =>$request->year,
            'stage' => $request->stage,
            'serreg_id' =>$request->serreg_id,
            'funded_status' => $request->funded_status
        ]);
    }
    public function budget_unfunded(Request $request)
    {
        return view('excel_templates.budget-unfunded',[
            'year' =>$request->year,
            'stage' => $request->stage_id,
            'serreg_id' =>$request->service_region_id,
            'funded_status' => $request->funded_status
        ]);
    }
    public function fiscal_limit(Request $request)
    {
        return view('excel_templates.fiscal-limit',[
            'year' =>2022,
            'stage' => 1,
        ])->render();
    }

}
