<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PriorityClass;
class PriorityClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorityClass = [
            ['Strategic Priority','SP'],
            ['Core Functions','CF'],
            ['Support Functions','SF'],
        ];

        foreach ($priorityClass as $pc) {
            PriorityClass::firstOrCreate([
                'class' => $pc[0],
                'accronym' => $pc[1],
            ]);
        }
    }
}
