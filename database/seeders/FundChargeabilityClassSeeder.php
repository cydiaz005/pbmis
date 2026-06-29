<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundChargeabilityClass;
use App\Models\AllotmentClass;
use App\Models\FundChargeability;

class FundChargeabilityClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  /*
        $ps	    General Administration and Support - PS
        $mooe	General Administration and Support - MOOE
        $mooe	Civil Defense Enhancement - MOOE
        $mooe	Disaster Risk Reduction and Management - MOOE
        $mooe	QUICK RESPONSE FUND - MOOE
        $co	General Administration and Support - CO
        $co	Civil Defense Enhancement - Capital Outlay
        $co	Disaster Risk Reduction and Management - CO
        $co	QUICK RESPONSE FUND - CO
        */
   
        $ps = AllotmentClass::where('code', '501')->pluck('id')->first();	
        $mooe = AllotmentClass::where('code', '502')->pluck('id')->first();	   
        $co = AllotmentClass::where('code', '506')->pluck('id')->first();

        $fundChargeabilityClass = [
            [$ps, FundChargeability::where('accronym', 'GASS')->pluck('id')->first()],
            [$mooe, FundChargeability::where('accronym', 'GASS')->pluck('id')->first()],
            [$mooe, FundChargeability::where('accronym', 'CDE')->pluck('id')->first()],
            [$mooe, FundChargeability::where('accronym', 'DRRM')->pluck('id')->first()],
            [$mooe, FundChargeability::where('accronym', 'QRF')->pluck('id')->first()],
            [$co, FundChargeability::where('accronym', 'GASS')->pluck('id')->first()],
            [$co, FundChargeability::where('accronym', 'CDE')->pluck('id')->first()],
            [$co, FundChargeability::where('accronym', 'DRRM')->pluck('id')->first()],
            [$co, FundChargeability::where('accronym', 'QRF')->pluck('id')->first()],
        ];


        foreach ($fundChargeabilityClass as $fcc) {
            FundChargeabilityClass::firstOrCreate([
                'ac_id' => $fcc[0],
                'fc_id' => $fcc[1],
            ]);
        }     
    }
}
