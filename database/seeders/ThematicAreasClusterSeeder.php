<?php

namespace Database\Seeders;

use App\Models\ThematicAreasCluster;
use Illuminate\Database\Seeder;

class ThematicAreasClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            "Prevention/Mitigation",
            "Preparedness",
            "Response",
            "Rehabilitation/Recovery",
            "Not Applicable",
        ];
        foreach ($data as $tac) {
            ThematicAreasCluster::create([
                "thematic_area_cluster"=>$tac
            ]);
        }
        
    }
}
