<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mfo;
class MfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mfo = [
            [1,"Training Programs for LDRRMOs and Volunteer Groups"],
            [1,"LDRRM Offices Assessed in Gawad KALASAG Seal"],
            [1,"Operations Center maintained"],
            [1,"LDRRM Plans Reviewed "],
            [1,"Gawad KALASAG Program"],
            [1,"Training Programs for Organizations"],
            [1,"ACDM and AMMDM deliverables and other related requirements"],
            [1,"NDRRM Plan Monitoring"],
            [1,"NDRRM Training Institute Provisional Activation"],
            [1,"Rehabilitation and Recovery Plan Guide User's Manual Roll-out"],
            [1,"Disaster Management Operations conducted and/or supported"],
            [1,"Total Quality Management System requirements"],
            [1,"Enhanced OSSP"],
            [2,"Plans and policies formulated"],
            [2,"Engagements and partnerships sustained and forged towards convergence and coherence"],
            [2,"IEC materials reproduced and disseminated"],
            [2,"IEC activities conducted"],
            [2,"Secretariat Services"],
            [2,"Technical Support and Assistance to stakeholder engagements"],
            [2,"Financial Assistance processed"],
            [2,"Relief Assistance provided "],
            [2,"NDRRM Fund requests processed"],
            [2,"Rapid Damage Assessment and Needs Analysis"],
            [2,"Post Disaster Needs Assessment"],
            [2,"Secretariat Services to the NTF-COVID 19"],
            [2,"Support to the Task Group on Resource Management and Logistics"],
            [2,"LDRRM Fund Utilization Reports"],
            [2,"Semi-annual report on risk assessment sub-cluster/working group"],
            [2,"Inputs to Inter-Agency Requests"],
            [3,"Monitoring and Evaluation of Regional Office Operations"],
            [3,"Program Implementation Review (PIR) of the DRRM and CD Education and Training Program at the National and Regional Level "],
            [3,"AO 25 Compliances"],
            [3,"Service/Division/Office Family Conference"],
            [3,"Senior Leaders' Conference"],
            [3,"Strategic Plan Monitoring Report"],
            [3,"Internal Technical and Secretariat Services"],
            [3,"Reports and Compliances"],
            [3,"Internal Policies developed"],
            [3,"Financial Services and Reports"],
            [3,"Procurement Management"],
            [3,"Facilities Management"],
            [3,"Supplies and Equipment Management "],
            [3,"Personnel Management "],
            [3,"Learning and Development Interventions"],
            [3,"Document Management"],
            [1,"Disaster Management Operations conducted and/or supported"],
            [1,"Disaster Management Operations conducted and/or supported"],
            [1,"Disaster Management Operations conducted and/or supported"],
            [1,"Gawad KALASAG Program"],
            [1,"LDRRM Offices Assessed in Gawad KALASAG Seal"],
            [1,"LDRRM Plans Reviewed"],
            [1,"Operation Center maintained"],
            [1,"Total Quality Management System requirements"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for Organizations"],
            [1,"Training Programs for volunteers and LDRRMOs"],
            [1,"Training Programs for volunteers and LDRRMOs"],
            [1,"Training Programs for volunteers and LDRRMOs"],
            [2,"Civil Defense Plans and Policies"],
            [2,"DRRM/CD Training Plan/Policy Developed/Updated"],
            [2,"IEC activities conducted"],
            [2,"IEC activities conducted"],
            [2,"IEC activities conducted"],
            [2,"IEC activities conducted"],
            [2,"IEC activities conducted"],
            [2,"IEC materials reproduced and disseminated"],
            [2,"Secretariat Services"],
            [2,"Secretariat Services"],
            [2,"Secretariat Services"],
            [3,"Facilities Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Personnel Management"],
            [3,"Procurement Management"],
            [3,"Program Implementation Review (PIR) of the DRRM and CD Education and Training Program at the National and Regional Level"],
            [3,"Reports and Compliances"],
            [3,"Reports and Compliances"],
            [3,"Supplies and Equipment Management"],
            [3,"Supplies and Equipment Management"],
            [3,"Supplies and Equipment Management"],
            [3,"Supplies and Equipment Management"],
        ];

        foreach ($mfo as $key=>$m) {
            Mfo::firstOrCreate([
                'pc_id' => $m[0],
                'desc' => $m[1],
                'order'=>$key+1
            ]);
        }
    }
}
