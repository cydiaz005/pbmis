<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = [
            ['name' => 'Indicative', 'accronym' => 'IND', 'active'=>'1'],
            ['name' => 'National Expenditure Program', 'accronym' => 'NEP', 'active'=>'0'],
            ['name' => 'General Appropriation Act', 'accronym' => 'GAA', 'active'=>'0'],
        ];

        foreach ($stages as $s) {
            Stage::firstOrCreate([
                'name' => $s['name'],
                'accronym' => $s['accronym'],
                'active' => $s['active'],
            ]);
        }
    }
}
