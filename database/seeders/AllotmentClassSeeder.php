<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AllotmentClass;

class AllotmentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allotmentClass = [
            // ['506', 'Capital Outlay', 'CO'],
            // ['501', 'Personnel Services', 'PS'],
            // ['502', 'Maintenance and Other Operating Expenses', 'MOOE'],
            
            ['502', 'Maintenance and Other Operating Expenses', 'MOOE'],
            ['501', 'Personnel Services', 'PS'],
            ['506', 'Capital Outlay', 'CO'],
        ];

        foreach ($allotmentClass as $ac) {
            AllotmentClass::firstOrCreate([
                'code' => $ac[0],
                'class' => $ac[1],
                'accronym' => $ac[2],
            ]);
        }
    }
}
