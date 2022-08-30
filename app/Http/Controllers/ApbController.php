<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApbController extends Controller
{
    public function report()
    {
       return view();
    }
    public function table(Request $request)
    {
        return view('excel_templates.apb', [
            "year"=>$request->year,
            'serreg_id' => $request->serreg_id,
            'funded_status' => $request->funded_status,
        ])->render();
    }
}
