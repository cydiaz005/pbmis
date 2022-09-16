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

        $division_sections = [
            ["name"=>"24/7 Operations Center","accronym"=>"24/7 OpCen",],
            ["name"=>"Administration","accronym"=>"ADMIN",],
            ["name"=>"Administrative And Financial Management Section","accronym"=>"AFMS",],
            ["name"=>"Curriculum Development And Training Division","accronym"=>"CDTD",],
            ["name"=>"DRRM Fund Management Division","accronym"=>"DFMD",],
            ["name"=>"Disaster Risk Governance Division","accronym"=>"DRGD",],
            ["name"=>"Disaster Risk Reduction And Management Division","accronym"=>"DRRMD",],
            ["name"=>"Financial Management Division","accronym"=>"FMD",],
            ["name"=>"General Services Division- Cash Disbursement Section","accronym"=>"GSD-CDS",],
            ["name"=>"Information And Communications Technology Division","accronym"=>"ICTD",],
            ["name"=>"Internal Monitoring And Evaluation Office","accronym"=>"IMEO",],
            ["name"=>"Knowledge Management Division","accronym"=>"KMD",],
            ["name"=>"National Disaster Risk Reduction And Management Training And Research Institute","accronym"=>"NDRRMTRI",],
            ["name"=>"Office Of The Civil Defense Administrator","accronym"=>"OCDA",],
            ["name"=>"Office Of The Director","accronym"=>"OD",],
            ["name"=>"Operations Section","accronym"=>"OS",],
            ["name"=>"Public Affairs Office","accronym"=>"PAO",],
            ["name"=>"Policy Development And Planning Section","accronym"=>"PDPS",],
            ["name"=>"Procurement Management Division","accronym"=>"PMD",],
            ["name"=>"Plans, Programs, And Project Development And Management Division","accronym"=>"PPPDMD",],
            ["name"=>"Plans And Programs Section","accronym"=>"PPS",],
            ["name"=>"Planning Section","accronym"=>"PS",],
            ["name"=>"Logistics Management Section","accronym"=>"ROCD",],
            ["name"=>"Rehabilitation And Recovery Management Section","accronym"=>"RRMS",],
            ["name"=>"Training And Education Research, Policy And Standards Development Division","accronym"=>"TERPSDD",],
        ];

        foreach ($division_sections as $division_section) {
            DivisionSection::firstOrCreate($division_section);
        }
    }
}
