<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DivisionSection;

class DivisionSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $divisionSection = [
            ["Plans, Programs, and Project Development and Management Division", "PPPDMD"],
            ["Policy Development and Planning Section", "DRRMD"],
            ["Information and Communications Technology Division", "ICTD"],
            ["Logistics Management Section", "ROCD"],
            ["Policy Development and Planning Section", "PDPS"],
            ["Internal Monitoring and Evaluation Office", "IMEO"],
            ["Office of the Civil Defense Administrator", "OCDA"],
            ["Office of the Director", "OD"],
            ["Office of the Civil Defense Administrator", "OCD"],
            ["Policy & Plans Sections", "PDPS"],
            ["Planning Section", "PS"],
            ["Disaster Risk Reduction Management Division", "DRRMD"],
            ["Policy Development and Planning Section", "PDPS"],
            ["Policy Development and Planning Section", "PDPS"],
            ["24/7 Operations Center", "24/7 OpCen"],
            ["Internal Monitoring and Evaluation Office", "IMEO"],
            ["Office of the Civil Defense Administrator", "OCDA"],
            ["Financial Management Division/ Budget Section", "FMD"],
            ["Procurement Management Division", "PMD"],
            ["General Services Division - Cash Disbursement Section", "GSD-CDS"],
            ["Policy Development and Planning Section", "PDPS"],
            ["Administrative and Financial Management Section ", "AFMS"],
            ["Admin and Finance Section", "AFMS"],
            ["Plans and Programs Section", "PPS"],
            ["Financial Management Division", "FMD"],
            ["Financial Management Division - Budget Section", "FMD-BS"],
            ["Administrative and Financial Management Section", "AFMS"],
            ["Operations Section - Information and Communications Technology Division", "OS-ICTD"],
            ["Operations Section", "OS"],
        ];

        foreach ($divisionSection as $ds) {
            DivisionSection::firstOrCreate([
                'accronym' => $ds[1],
            ], [
                'name' => $ds[0],
            ]);
        }
    }
}
