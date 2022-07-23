<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;
use App\Models\FiscalLimit;
use App\Models\ServiceRegion;
use App\Models\FundChargeabilityClass;
class FiscalLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $stages = Stage::all();
        $stages = Stage::where('active', '1')->get();

        $serviceRegion = ServiceRegion::all();
        $fundChargeabilityClass = FundChargeabilityClass::all();


        foreach ($stages as $st) {
            // echo "\n Creating fiscal limit on stage: ".$stages."\n";

            foreach ($fundChargeabilityClass as $fcc) {
                foreach ($serviceRegion as $sr) {
                    $fiscal_limit = FiscalLimit::updateOrCreate(
                        [
                            'cat_id' => $fcc->id,
                            'stage_id' => $st->id,
                            'serreg_id' => $sr->id,
                        ],
                        [
                            'amount' => rand('1000000','9000000')
                        ]
                    );
                }
            }
        }
        echo "\n Running iteration: ".$stages."\n";


    }
}
