<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListOfPap;

class ListOfPapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "Community-Based DRRM Training [for target sector] [in province]",
            "Basic Incident Command System Training [for target sector] [in province]",
            "Emergency Operations Center Training [for target sector] [in province]",
            "Gawad KALASAG Seal for LDRRMOs: Local DRRM Offices Assessment and Evaluation",
            "Management of 24/7 Operations Center",
            "Standard Operating Procedure and Guidelines (SOPG) of Operations Center",
            "Disaster Risk Reduction and Management (DRRM) Training  [for target sector] [in province]",
            "Local DRRM Planning Training [for target sector] [in province]",
            "Contingency Planning Training Course [for target sector] [in province]",
            "Public Service Continuity Planning Training Course [for target sector] [in province]",
            "Gawad KALASAG Seal for Special Awards",
            "Local DRRM Plan Review  ",
            "Program Implementation Review",
            "Public Service Continuity Plan Activities",
            "RDRRMC Full Council Meetings",
            "Thematic/TWG Meetings",
            "Updating/Revision of the Regional DRRM Plan",
            "Nationwide Simultaneous Earthquake Drill",
            "Quad Media Programs",
            "Regional Newsletter/Gazette",
            "Regional DRRM Caravan",
            "National Disaster Resilience Month",
            "Arbor Day/ Juan for Treesilience",
            "Regional Prroject Monitoring and Evaluiatuon Team Actiities",
            "Mandatory Expenses",
            "Administrative Travels and Requirements",
            "Total Quality Management System Activities",
            "Team Building/Synergy",
            "Annual Fellowship Program",
            "OCD Anniversary Celebration",
            "Annual Medical Check-up ",
            "Mental Health & Wellness Program",
            "RT-PCR Testing and Quarantine Requirements for OCD Personnel",
            "Regular Immunization (Flu, Pneumonia, etc.)",
            "Shuttle Service for OCD Personnel",
            "Sustainment of Operations",
            "Bids and Awards Committtee Meetings",
            "Operational Readiness of Motor Vehicles",
            "Operational Readiness of Office Equipment",
            "Operational Readiness of ICT Equipment",
            "Operational Readiness of Furniture and Fixture",
            "Operational Readiness of Communication Equipment",
            "Repair and Maintenance Expenses",
            "Operational Readiness of Admin Building & Warehouse",
            "Warehouse Rental",
            "Conduct of /Attendance to PAMB Activities",
            "Conduct of /Attendance to NTF-ELCAC Activities",
            "Conduct of /Attendance to Regional Development Council Activities",
            "Conduct of/Attendance to RPOC Activities",
            "Conduct of /Attendance to [event]",
            "Surveillance Meeting & Activation of OpCen",
            "Activation of Incident Management Team",
            "Activation of Operations Center for Special Events",
            "Support to Duty Personnel (Blue/Red Alert)",
            "Mobilization of Responders",
            "Disaster Rehabilitation and Recovery Activities",
            "Support to COVID19 Response",
        ];
        foreach ($data as $pap) {
            ListOfPap::create([
                "paps"=>$pap
            ]);
        }
    }
}
