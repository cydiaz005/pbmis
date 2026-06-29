<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $position = [
            "Administrative Assistant II ",
            "Administrative Assistant III",
            "Administrative Officer I",
            "Administrative Officer II",
            "Administrative Officer IV",
            "Administrative Officer V",
            "Assistant Chief",
            "Chief",
            "Chief, Budget And Finance Unit",
            "Chief, Planning Section",
            "Civil Defense Office II",
            "Civil Defense Officer I",
            "Civil Defense Officer II",
            "Civil Defense Officer III",
            "Civil Defense Officer III/ Acting Head, OS",
            "Civil Defense Officer IV",
            "Computer Maintenance Technnologist I",
            "CP II",
            "Information Officer II",
            "OS Staff / Contract Of Service ",
            "Planning Officer I",
            "Public Relations Officer I",
            "Public Relations Officer III",
            "Special Disbursing Officer",
            "Technical Support Staff",
            "Training Assistant",
        ];

        foreach ($position as $p) {
            Position::firstOrCreate([
                'job_title' => $p
            ]);
        }
    }
}
