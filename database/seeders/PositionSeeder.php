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
            "Civil Defense Officer II",
            "Technical Staff",
            "Computer Maintenance Technologist I",
            "CIVIL DEFENSE OFFICER III",
            "Civil Defense Officer III",
            "TECHNICAL SUPPORT",
            "Technical Support Staff",
            "Public Relations Officer III",
            "Civil Defense Officer III",
            "Technical Support ",
            "Civil Defense Officer II",
            "Chief, Planning Section",
            "ADOF IV",
            "Civil Defense Officer III",
            "Technical Staff",
            "Civil Defense Officer I",
            "Technical Support Staff",
            "Technical Support",
            "Administrative Officer IV",
            "Civil Defense Officer II",
            "Administrative Officer II",
            "CHIEF",
            "ADMIN OFFICER I",
            "Civil Defense Officer II",
            "Civil Defense officer II",
            "Civil Defense Office II",
            "Chief",
            "Administrative Officer V",
            "Administrative Assistant II ",
            "Assistant chief",
            "Civil Defense Officer II",
            "CDO IV",
            "Civil Defense Officer III",
            "Technical Support",
            "Civil Defense Officer I",
            "OS Staff / Contract of Service ",
        ];

        foreach ($position as $p) {
            Position::firstOrCreate([
                'job_title' => $p
            ]);
        }
    }
}
