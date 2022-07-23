<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfficeMfo;

class OfficeMfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $oms = [
            [1,2],
            [1,3],
            [1,6],
            [3,2],
            [3,3],
            [3,10],
            [3,12],
            [2,3],
            [2,2],
            [2,1],
            [2,20],
            [2,12],
        ];
        
        
        foreach ($oms as $key=>$om) {
            OfficeMfo::firstOrCreate([
                'office_id' => $om[0],
                'mfo_id' => $om[1],
            ]);
        }
    }
}
