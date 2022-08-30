<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KdpKpKs;
use App\Models\Mfo;

class KdpKpKsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kdpKpKs=[
            ["Supplies and Equipment Management","Administrative and Logistical Requirements"],
            ["Reports and Compliances","Administrative and Logistical Requirements"],
            ["Total Quality Management System requirements","Administrative and Logistical Requirements"],
            ["Supplies and Equipment Management","Administrative Support Requirements"],
            ["Procurement Management","Administrative Support Requirements"],
            ["Training Programs for volunteers and LDRRMOs","Civil Defense Capacity Building Initiatives"],
            ["Training Programs for volunteers and LDRRMOs","Civil Defense Capacity Building Initiatives"],
            ["Training Programs for volunteers and LDRRMOs","Civil Defense Capacity Building Initiatives"],
            ["Civil Defense Plans and Policies","Civil Defense Plans and Policies"],
            ["LDRRM Offices Assessed in Gawad KALASAG Seal","Civil Defense Readiness Assessment Services"],
            ["Disaster Management Operations conducted and/or supported","Disaster Monitoring Activities"],
            ["Disaster Management Operations conducted and/or supported","Disaster Rehabilitation and Recovery Activities"],
            ["Disaster Management Operations conducted and/or supported","Disaster Response Activities"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["Training Programs for Organizations","DRRM Capacity Building Initiatives"],
            ["IEC activities conducted","DRRM IEC Activities"],
            ["IEC activities conducted","DRRM IEC Activities"],
            ["IEC materials reproduced and disseminated","DRRM IEC Activities"],
            ["IEC activities conducted","DRRM IEC Activities"],
            ["IEC activities conducted","DRRM IEC Activities"],
            ["IEC activities conducted","DRRM IEC Activities"],
            ["DRRM/CD Training Plan/Policy Developed/Updated","DRRM Plans and Policies"],
            ["Gawad KALASAG Program","DRRM Readiness Assessment Services"],
            ["LDRRM Plans Reviewed","DRRM Readiness Assessment Services"],
            ["Program Implementation Review (PIR) of the DRRM and CD Education and Training Program at the National and Regional Level","DRRM Readiness Assessment Services"],
            ["Supplies and Equipment Management","Equipment Readiness"],
            ["Facilities Management","Facility Readiness"],
            ["Supplies and Equipment Management","Maintenance Readiness"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Personnel Management","Morale and Welfare"],
            ["Operation Center maintained","Operation Center maintained"],
            ["Reports and Compliances","Other Regional Engagements"],
            ["Secretariat Services","Support to Secretariat Functions"],
            ["Secretariat Services","Support to Secretariat Functions"],
            ["Secretariat Services","Support to Secretariat Functions"],
        ];

        foreach ($kdpKpKs as $k) {
            KdpKpKs::firstOrCreate([
                'desc' => $k[1],
            ]);
        }
        
        
    }
}
