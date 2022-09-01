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
            ["24/7 Operations Center","24/7 OpCen"],
            ["Administration","ADMIN"],
            ["Administrative And Financial Management Section ","AFMS"],
            ["Curriculum Development And Training Division","CDTD"],
            ["DRRM Fund Management Division","DFMD"],
            ["Disaster Risk Governance Division","DRGD"],
            ["Disaster Risk Reduction And Management Division","DRRMD"],
            ["Financial Management Division","FMD"],
            ["General Services Division- Cash Disbursement Section","GSD-CDS"],
            ["Information And Communications Technology Division","ICTD"],
            ["Internal Monitoring And Evaluation Office","IMEO"],
            ["Knowledge Management Division","KMD"],
            ["National Disaster Risk Reduction And Management Training And Research Institute","NDRRMTRI"],
            ["Office Of The Civil Defense Administrator","OCDA"],
            ["Office Of The Director","OD"],
            ["Operations Section","OS"],
            ["Public Affairs Office","PAO"],
            ["Policy Development And Planning Section","PDPS"],
            ["Procurement Management Division","PMD"],
            ["Plans, Programs, And Project Development And Management Division","PPPDMD"],
            ["Plans And Programs Section","PPS"],
            ["Planning Section","PS"],
            ["Logistics Management Section","ROCD"],
            ["Rehabilitation And Recovery Management Section","RRMS"],
            ["Training And Education Research, Policy And Standards Development Division","TERPSDD"],





            // ["Plans, Programs, and Project Development and Management Division", "PPPDMD"],
            // ["Policy Development and Planning Section", "DRRMD"],
            // ["Information and Communications Technology Division", "ICTD"],
            // ["Logistics Management Section", "ROCD"],
            // ["Policy Development and Planning Section", "PDPS"],
            // ["Internal Monitoring and Evaluation Office", "IMEO"],
            // ["Office of the Civil Defense Administrator", "OCDA"],
            // ["Office of the Director", "OD"],
            // ["Office of the Civil Defense Administrator", "OCD"],
            // ["Policy & Plans Sections", "PDPS"],
            // ["Planning Section", "PS"],
            // ["Disaster Risk Reduction Management Division", "DRRMD"],
            // ["Policy Development and Planning Section", "PDPS"],
            // ["Policy Development and Planning Section", "PDPS"],
            // ["24/7 Operations Center", "24/7 OpCen"],
            // ["Internal Monitoring and Evaluation Office", "IMEO"],
            // ["Office of the Civil Defense Administrator", "OCDA"],
            // ["Financial Management Division/ Budget Section", "FMD"],
            // ["Procurement Management Division", "PMD"],
            // ["General Services Division - Cash Disbursement Section", "GSD-CDS"],
            // ["Policy Development and Planning Section", "PDPS"],
            // ["Administrative and Financial Management Section ", "AFMS"],
            // ["Admin and Finance Section", "AFMS"],
            // ["Plans and Programs Section", "PPS"],
            // ["Financial Management Division", "FMD"],
            // ["Financial Management Division - Budget Section", "FMD-BS"],
            // ["Administrative and Financial Management Section", "AFMS"],
            // ["Operations Section - Information and Communications Technology Division", "OS-ICTD"],
            // ["Operations Section", "OS"],
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
