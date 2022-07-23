<?php

namespace Database\Seeders;

use App\Models\QuarterTarget;
use Illuminate\Database\Seeder;

class QuarterTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            "MoMs",
            "AAR",
            "ATR",
            "Policy",
            "Meetings",
            "Activities conducted",
            "APB Book",
            "Annual Report",
            "Written Report",
            "Lot",
            "Activity",
            "Written Report",
            "Presentation",
            "Activities conducted",
            "Compliance",
            "ARs submitted",
        ];

        foreach ($data as $qt) {
            QuarterTarget::create([
                "quarter_target"=>$qt
            ]);
        }
        
    }
}
