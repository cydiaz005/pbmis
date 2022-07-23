<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListOfItemRequirement;

class ListOfItemRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            "Local Travels (Airfare, Landfare, Boatfare etc. including Meals and Accom if Not Training Activity)",
            "Foreign Travels (Airfare, Landfare, Boatfare etc. including Meals and Accom if Not Training Activity)",
            "All Expenses incurred during Training Proper (Office Supplies, Meals and Accommodation, Honoraria etc. EXCEPT Travelling Expenses, Printing and Binding Expenses)",
            "All Common - Used Office Supplies",
            "All Food Expenses incurred in activities EXCEPT Training Activities, Meetings and Conferences)",
            "Fuel, Oil,and Lubricants",
            "All Supplies that doesn’t fall under OFFICE SUPPLIES (T-shirts, Plaques, Lei, NFIs, PPGs, Eco Bags etc.)",
            "Water Consumption",
            "Payment for Consultants",
            "Project Based Hiring",
            "Payment for Utility Workers",
            "Payment for General Services (Driver, Watchman, etc.)",
            "Preventive and Corrective Maintenance of Building",
            "Preventive and Corrective Maintenance of Office Equipment",
            "Preventive and Corrective Maintenance of IT Equipment",
            "Preventive and Corrective Maintenance of Communications Equipment",
            "Preventive and Corrective Maintenance of Motor Vehicles",
            "Preventive and Corrective Maintenance of Furniture and Fixtures",
            "Payment of Taxes and Licenses including Emission Testing",
            "Bond Premiums of Accountable Officers",
            "Payment of Insurances of Buildings and Motor Vehicles",
            "TV/ Radio Advertisements",
            "Printing/ Photocopying/ Binding",
            "Meals and Snacks incurred during Meetings and Conferences",
            "Electricity Consumption",
            "Postage and Courier Services",
            "Payment of prepaid cards and postpaid billings",
            "Landline expenses",
            "Internet expenses",
            "Cable expenses",
            "Cash Awards (GK, NDCM, etc.)",
            "Expenses for Transportation of Big Items",
            "Rental of Office Buildings and Warehouses",
            "Rental of Office Equipment",
            "Newspaper Subscription",
            "All Expenses that does not fall on all codes above",
            "Rental of Motor Vehicles",
            "All Expenses that do not fall on all codes above",
        ];

        foreach ($data as $item) {
            ListOfItemRequirement::create([
                "ireq"=>$item
            ]);
        }
    }
}
