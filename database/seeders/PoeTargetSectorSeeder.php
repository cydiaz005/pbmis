<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormPoe;
use App\Models\TargetSector;
use App\Models\FormPoeTargetSector;
class PoeTargetSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formPoes = FormPoe::all();
        $targetSectors = TargetSector::all();
        $dummyTargetSectors = rand(1,3);

        foreach ($formPoes as $formPoe) {
            for ($dts=0; $dts < $dummyTargetSectors; $dts++) { 
                FormPoeTargetSector::firstOrCreate([
                    'poe_id' => $formPoe->id,
                    'target_sector_id' => rand(1, count($targetSectors)),
                ]);
            }
           

        }

    }
}
