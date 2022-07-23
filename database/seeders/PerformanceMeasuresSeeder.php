<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerformanceMeasures;
use Carbon\Carbon;

class PerformanceMeasuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        
        $performanceMeasures = [
            ['name'=>'Quality','legend'=> 'Ql','created_at'=>$timestamp,'updated_at'=>$timestamp],
            ['name'=>'Quantity','legend'=> 'Qn','created_at'=>$timestamp,'updated_at'=>$timestamp],
            ['name'=>'Timeliness','legend'=> 'T','created_at'=>$timestamp,'updated_at'=>$timestamp],
        ];
        PerformanceMeasures::insert($performanceMeasures);

    }
}
