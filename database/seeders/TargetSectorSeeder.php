<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetSector;

class TargetSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $targetSector = [
            "Farmers and Landless",
            "Artisanal Fisherfolk",
            "Urban Poor",
            "IPs and ICCs",
            "Formal/Migrant Workers",
            "Informal Sector",
            "Women",
            "Children",
            "Students/Youth",
            "Senior Citizens",
            "PWDs",
            "Victims of Disasters",
            "NGOs",
            "Cooperatives",
            "NDRRMC-member agencies",
            "RDRRMC-member agencies",
            "OCD personnel/employees",
            "LGUs",
            "Sectoral Ggit roups",
            "NGAs",
            "GOCCs",
            "People's Organization",
            "Religious Organization",
            "Civil Society Organization",
            "Volunteer Organization",
        ];

        foreach ($targetSector as $ts) {
            TargetSector::firstOrCreate([
                'sector' => $ts,
            ]);
        }
    }
}
