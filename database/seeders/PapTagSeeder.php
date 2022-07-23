<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PapTag;

class PapTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $papTag = [
            "Gender and Development Related",
            "Youth Related",
            "Climate Change Related",
        ];

        foreach ($papTag as $pt) {
            PapTag::firstOrCreate([
                'tag' => $pt
            ]);
        }

    }
}
