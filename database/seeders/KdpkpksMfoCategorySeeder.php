<?php

namespace Database\Seeders;
use App\Models\KdpKpKs;
use App\Models\Mfo;
use App\Models\KdpkpksMfoCategory;

use Illuminate\Database\Seeder;

class KdpkpksMfoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KdpkpksMfoCategory::firstOrCreate([
            'kdpkpks_id'=>1,
            'mfo_id'=>1
        ]);
    }
}
