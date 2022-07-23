<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FundChargeabilityAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fundChargeabilityClass = [
            "501" => [
                "5010101001",//"Salaries  and Wages - Regular - Basic Salary -Civilian"],
                "5010201001",//"Personnel Economic Relief Allowances(PERA) -Civilian"],
                "5010203001",//"Representation Allowance (RA)"],
                "5010202000",//"Transportation Allowance (TA)"],
                "5010204001",//"Clothing/Uniform Allowance - Civilian"],
                "5010215001",//"Cash Gift - Civilian"],
                "5010299011",//"Collective Negotiation Agreement Incentives - Civilian"],
                "5010299012",//"Performance Enhancement Incentive - Civilian "],
                "5010299036",//"Mid-Year Bonus - Civilian"],
                "5010214000",//"Year-end Bonus - Civilian"],
                "5010499099",//"Other Personnel Benefits"],
                "5010302001",//"Pag-IBIG - Civilian"],
                "5010303001",//"PhilHealth - Civilian"],
                "5010304001",//"Employees Compensation Insurance Premiums - Civilian"],
                "5010403001",//"Terminal Leave Benefits - Civilian"],
                "5010499010",//"Lump-sum for Step Increments - Length of Service"],
                "5010212001",//"Loyalty Award - Civilian"],
            ],

            "502" => [
                "5020101000",//"Travelling Expenses - Local"
                "5020102000",//"Travelling Expenses - Foreign"
                "5020201002",//"Training Expenses"
                "5020301000",//"Office Supplies Expenses"
                "5020305000",//"Food Supplies Expenses"
                "5020309000",//"Fuel, Oil and Lubricants Expenses"
                "5020399000",//"Other Supplies and Materials Expenses"
                "5020401000",//"Water Expenses"
                "5020402000",//"Electricity Expenses"
                "5020501000",//"Postage and Courier Services"
                "5020502001",//"Telephone Expenses - Mobile"
                "5020502002",//"Telephone Expenses - Landline"
                "5020503000",//"Internet Subscription Expenses"
                "5020504000",//"Cable, Satellite, Telegraph, and Radio Expenses"
                "5020601001",//"Awards/Reward Expenses"
                "5021003000",//"Extraordinary and Miscellaneous Expenses"
                "5021103002",//"Consultancy Services"
                "5021202000",//"Janitorial Services"
                "5021299000",//"Other General Services"
                "5021199000",//"Other Professional Services"
                "5021304000",//"Repairs and Maintenance- Buildings and Other Structures"
                "5021305003",//"Repairs and Maintenance-ICT Equipment"
                "5021305002",//"Repairs and Maintenance - Office Equipment"
                "5021305007",//"Repairs and Maintenance - Communication Equipment"
                "5021306000",//"Repairs and Maintenance - Motor Vehicles"
                "5021307000",//"Repairs and Maintenance-Furniture and Fixtures"
                "5021501001",//"Taxes, Duties and Licenses"
                "5021502000",//"Fidelity Bond Premiums"
                "5021503000",//"Insurance Expenses"
                "5029908000",//"Donations"
                "5029901000",//"Advertising Expenses"
                "5029902000",//"Printing and Publication Expenses"
                "5029903000",//"Representation Expenses"
                "5029904000",//"Transportation and Delivery Expenses"
                "5029905001",//"Rents - Building and Structures"
                "5029905004",//"Rents- Equipment"
                "5029907099",//"Other Subscription Expenses"
                "5029999099",//"Other Maintenance & Operating Expenses"
            ]//
           
            
        ];

        print_r(array_keys($fundChargeabilityClass));
        foreach ($fundChargeabilityClass as $fcc) {
            
            // FundChargeability::firstOrCreate([
            //     'code' => $fc[0],
            //     'type' => $fc[1],
            //     'accronym' => $fc[2],
            // ]);
        }
    }
}
