<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundSource;

class FundSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fundSource = [
            [1, 'Capital Outlay', 'CO'],
            [2, 'Civil Defense Enhancement Fund', 'CDE'],
            [3, 'Disaster Risk Reduction Management' , 'DRRM'],
            [4, 'General Administration and Support Services', 'GASS'],
            [5, 'Personnel Services', 'PS'],
            [6, 'QRF Ceiling for Central Office', 'QRFC-CO'],
            [7, 'Quick Response Fund (QRF) Ceiling by ROs', 'QRFC-RO'],
        ];

        foreach ($fundSource as $fs) {
            FundSource::firstOrCreate([
                'id' => $fs[0],
                'type' => $fs[1],
                'accronym' => $fs[2],
            ]);
        }
       
    }
}
