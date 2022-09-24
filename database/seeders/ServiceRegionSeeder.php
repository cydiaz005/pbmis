<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRegion;
class ServiceRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ["Region I", "ROI", 0, 1, 1],
            ["Region II", "ROII", 0, 1, 1],
            ["Region III", "ROIII", 0, 1, 1],
            ["Region IV-A", "ROIVA", 0, 1, 1],
            ["Region IV-B", "ROIVB", 0, 1, 1],
            ["Region V", "ROV", 0, 1, 1],
            ["Region VI", "ROVI", 0, 1, 1],
            ["Region VII", "ROVII", 0, 1, 1],
            ["Region VIII", "ROVIII", 0, 1, 1],
            ["Region IX", "ROIX", 0, 1, 1],
            ["Region X", "ROX", 0, 1, 1],
            ["Region XI", "ROXI", 0, 1, 1],
            ["Region XII", "ROXII", 0, 1, 1],
            ["Region XIII", "ROXIII", 0, 1, 1],
            ["Bangsamoro Autonomous Region in Muslim Mindanao", "BARMM", 0, 1, 1],
            ["Caraga", "CARAGA", 0, 1, 1],
            ["Cordillera Administrative Region", "CAR", 0, 1, 1],
            ["National Capital Region", "NCR", 0, 1, 1],
            ["Administrative and Financial Management Service", "AFMS", 1, 1, 2],
            ["Interim Disaster Preapredness Service", "IDPS", 1, 1, 2],
            ["Operations Service", "OS", 1, 1, 2],
            ["Policy Development and Planning Service", "PDPS", 1, 1, 2],
            ["Rehabilitation and Recovery Management Service", "RRMS", 1, 1, 2],
            ["Executive Office", "EO", 1, 1, 2],
            ["Quick Response Fund", "QRF", 1, 0, 2],
            ["Disaster Management Operations - Fiscal Space", "DMO", 1, 0, 2],
            ["Management Reserve - Fiscal Space", "MRE", 1, 0, 2],
        ];

        foreach ($regions as $r) {
            ServiceRegion::create([
                "service_region" => $r[0],
                "accronym" => $r[1],
                "co" => $r[2],
                "fillable" => $r[3],
                "office_id" => $r[4],

            ]);
        }
    }
}
