<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundChargeability;
class FundChargeabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fundChargeability = [
            ['310101100001000', 'Civil Defense Enhancement', 'CDE'],
            ['310102100001000', 'Disaster Risk Reduction Management' , 'DRRM'],
            ['100000100001000', 'General Administration and Support Services', 'GASS'],
            ['310103100001000', 'Quick Response Fund', 'QRF'],
            ['000000000000000', 'Government of the Philippines', 'GOP'],
        ];

        foreach ($fundChargeability as $fc) {
            $test = FundChargeability::firstOrCreate([
                'code' => $fc[0],
                'type' => $fc[1],
                'accronym' => $fc[2],
            ]);
        }
    }
}
