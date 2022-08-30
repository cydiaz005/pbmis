<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            'Regional Office',
            'Central Office',
            'Others'
        ];
        
        foreach ($offices as $o) {
            Office::firstOrCreate([
                'name' => $o
            ]);
        }
    }
}
