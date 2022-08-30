<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Units;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            'pcs',
            'pax',
            'set',
        ];

        foreach ($units as $u) {
            Units::firstOrCreate([
                'unit' => $u,
            ]);
        }
    }
}
