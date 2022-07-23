<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcurementMode;
class ProcurementModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $procurementMode = [
            [10, "Public Bidding"],
            [49, "Limited Source Bidding"],
            [50, "Direct Contracting"],
            [51, "Repeat Order"],
            [52, "Shopping"],
            [53.1, "Two Failed Bidding"],
            [53.2, "Emergency Cases"],
            [53.3, "Take Over Contract"],
            [53.4, "Adjacent or Contiguous"],
            [53.5, "Agency-to-Agency"],
            [53.6, "Scientific, Scholarly or Artistic Work, Exclusive Technology and Media Services"],
            [53.7, "Highly Technical Consultant"],
            [53.9, "Small Value Procurement"],
            [53.1, "Lease of Property and Venue"],
            [53.11, "NGO Participation"],
            [53.12, "Community Participation"],
            [53.13, "United Nations Agencies, International Organizations or International Financing Institutions"],
            [53.14, "Direct Retail Purchase of Petroleum Fuel, Oil and Lubricant (POL) and Airline Tickets"],
        ];
        foreach ($procurementMode as $pm) {
            ProcurementMode::firstOrCreate(
                ['section' => $pm[0]],
                ['title' => $pm[1]],
            );
        }
    }
}
