<?php

namespace Database\Seeders;
use App\Models\FundChargeabilityClassAccount;
use App\Models\AllotmentClass;
use App\Models\ChartOfAccounts;



use Illuminate\Database\Seeder;

class FundChargeabilityClassAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
       $fundChargeabilityClassAccount = [
            // 501,"General Administration and Support - PS"
            '1' => [ 
                ChartOfAccounts::where('code', '5010101001')->pluck('id')->first(),//"Salaries  and Wages - Regular - Basic Salary -Civilian"
                ChartOfAccounts::where('code', '5010201001')->pluck('id')->first(),//"Personnel Economic Relief Allowances(PERA) -Civilian"
                ChartOfAccounts::where('code', '5010203001')->pluck('id')->first(),//"Representation Allowance (RA)"
                ChartOfAccounts::where('code', '5010202000')->pluck('id')->first(),//"Transportation Allowance (TA)"
                ChartOfAccounts::where('code', '5010204001')->pluck('id')->first(),//"Clothing/Uniform Allowance - Civilian"
                ChartOfAccounts::where('code', '5010215001')->pluck('id')->first(),//"Cash Gift - Civilian"
                ChartOfAccounts::where('code', '5010299011')->pluck('id')->first(),//"Collective Negotiation Agreement Incentives - Civilian"
                ChartOfAccounts::where('code', '5010299012')->pluck('id')->first(),//"Performance Enhancement Incentive - Civilian "
                ChartOfAccounts::where('code', '5010299036')->pluck('id')->first(),//"Mid-Year Bonus - Civilian"
                ChartOfAccounts::where('code', '5010214000')->pluck('id')->first(),//"Year-end Bonus - Civilian"
                ChartOfAccounts::where('code', '5010499099')->pluck('id')->first(),//"Other Personnel Benefits"
                ChartOfAccounts::where('code', '5010302001')->pluck('id')->first(),//"Pag-IBIG - Civilian"
                ChartOfAccounts::where('code', '5010303001')->pluck('id')->first(),//"PhilHealth - Civilian"
                ChartOfAccounts::where('code', '5010304001')->pluck('id')->first(),//"Employees Compensation Insurance Premiums - Civilian"
                ChartOfAccounts::where('code', '5010403001')->pluck('id')->first(),//"Terminal Leave Benefits - Civilian"
                ChartOfAccounts::where('code', '5010499010')->pluck('id')->first(),//"Lump-sum for Step Increments - Length of Service"
                ChartOfAccounts::where('code', '5010212001')->pluck('id')->first(),//"Loyalty Award - Civilian"
            ],
            // 502,"General Administration and Support - MOOE"
            '2' => [
                ChartOfAccounts::where('code', '5020101000')->pluck('id')->first(),//"Travelling Expenses - Local"
                ChartOfAccounts::where('code', '5020102000')->pluck('id')->first(),//"Travelling Expenses - Foreign"
                ChartOfAccounts::where('code', '5020201002')->pluck('id')->first(),//"Training Expenses"
                ChartOfAccounts::where('code', '5020301000')->pluck('id')->first(),//"Office Supplies Expenses"
                ChartOfAccounts::where('code', '5020305000')->pluck('id')->first(),//"Food Supplies Expenses"
                ChartOfAccounts::where('code', '5020309000')->pluck('id')->first(),//"Fuel, Oil and Lubricants Expenses"
                ChartOfAccounts::where('code', '5020399000')->pluck('id')->first(),//"Other Supplies and Materials Expenses"
                ChartOfAccounts::where('code', '5020401000')->pluck('id')->first(),//"Water Expenses"
                ChartOfAccounts::where('code', '5020402000')->pluck('id')->first(),//"Electricity Expenses"
                ChartOfAccounts::where('code', '5020501000')->pluck('id')->first(),//"Postage and Courier Services"
                ChartOfAccounts::where('code', '5020502001')->pluck('id')->first(),//"Telephone Expenses - Mobile"
                ChartOfAccounts::where('code', '5020502002')->pluck('id')->first(),//"Telephone Expenses - Landline"
                ChartOfAccounts::where('code', '5020503000')->pluck('id')->first(),//"Internet Subscription Expenses"
                ChartOfAccounts::where('code', '5020504000')->pluck('id')->first(),//"Cable, Satellite, Telegraph, and Radio Expenses"
                ChartOfAccounts::where('code', '5020601001')->pluck('id')->first(),//"Awards/Reward Expenses"
                ChartOfAccounts::where('code', '5021003000')->pluck('id')->first(),//"Extraordinary and Miscellaneous Expenses"
                ChartOfAccounts::where('code', '5021103002')->pluck('id')->first(),//"Consultancy Services"
                ChartOfAccounts::where('code', '5021202000')->pluck('id')->first(),//"Janitorial Services"
                ChartOfAccounts::where('code', '5021299000')->pluck('id')->first(),//"Other General Services"
                ChartOfAccounts::where('code', '5021199000')->pluck('id')->first(),//"Other Professional Services"
                ChartOfAccounts::where('code', '5021304000')->pluck('id')->first(),//"Repairs and Maintenance- Buildings and Other Structures"
                ChartOfAccounts::where('code', '5021305003')->pluck('id')->first(),//"Repairs and Maintenance-ICT Equipment"
                ChartOfAccounts::where('code', '5021305002')->pluck('id')->first(),//"Repairs and Maintenance - Office Equipment"
                ChartOfAccounts::where('code', '5021305007')->pluck('id')->first(),//"Repairs and Maintenance - Communication Equipment"
                ChartOfAccounts::where('code', '5021306000')->pluck('id')->first(),//"Repairs and Maintenance - Motor Vehicles"
                ChartOfAccounts::where('code', '5021307000')->pluck('id')->first(),//"Repairs and Maintenance-Furniture and Fixtures"
                ChartOfAccounts::where('code', '5021501001')->pluck('id')->first(),//"Taxes, Duties and Licenses"
                ChartOfAccounts::where('code', '5021502000')->pluck('id')->first(),//"Fidelity Bond Premiums"
                ChartOfAccounts::where('code', '5021503000')->pluck('id')->first(),//"Insurance Expenses"
                ChartOfAccounts::where('code', '5029908000')->pluck('id')->first(),//"Donations"
                ChartOfAccounts::where('code', '5029901000')->pluck('id')->first(),//"Advertising Expenses"
                ChartOfAccounts::where('code', '5029902000')->pluck('id')->first(),//"Printing and Publication Expenses"
                ChartOfAccounts::where('code', '5029903000')->pluck('id')->first(),//"Representation Expenses"
                ChartOfAccounts::where('code', '5029904000')->pluck('id')->first(),//"Transportation and Delivery Expenses"
                ChartOfAccounts::where('code', '5029905001')->pluck('id')->first(),//"Rents - Building and Structures"
                ChartOfAccounts::where('code', '5029905004')->pluck('id')->first(),//"Rents- Equipment"
                ChartOfAccounts::where('code', '5029907099')->pluck('id')->first(),//"Other Subscription Expenses"
                ChartOfAccounts::where('code', '5029999099')->pluck('id')->first(),//"Other Maintenance & Operating Expenses"

            ],
            // 502,"Civil Defense Enhancement - MOOE"
            '3' => [
                ChartOfAccounts::where('code', '5020101000')->pluck('id')->first(),//"Travelling Expenses - Local"
                ChartOfAccounts::where('code', '5020102000')->pluck('id')->first(),//"Travelling Expenses - Foreign"
                ChartOfAccounts::where('code', '5020201002')->pluck('id')->first(),//"Training Expenses"
                ChartOfAccounts::where('code', '5020301002')->pluck('id')->first(),//"Office Supplies Expenses"
                ChartOfAccounts::where('code', '5020305000')->pluck('id')->first(),//"Food Supplies Expenses"
                ChartOfAccounts::where('code', '5020309000')->pluck('id')->first(),//"Fuel, Oil and Lubricants Expenses"
                ChartOfAccounts::where('code', '5020399000')->pluck('id')->first(),//"Other Supplies and Materials Expenses"
                ChartOfAccounts::where('code', '5020402000')->pluck('id')->first(),//"Electricity Expenses"
                ChartOfAccounts::where('code', '5020501000')->pluck('id')->first(),//"Postage and Courier Services"
                ChartOfAccounts::where('code', '5020502001')->pluck('id')->first(),//"Telephone Expenses - Mobile"
                ChartOfAccounts::where('code', '5020502002')->pluck('id')->first(),//"Telephone Expenses - Landline"
                ChartOfAccounts::where('code', '5020503000')->pluck('id')->first(),//"Internet Subscription Expenses"
                ChartOfAccounts::where('code', '5020504000')->pluck('id')->first(),//"Cable, Satellite, Telegraph, and Radio Expenses"
                ChartOfAccounts::where('code', '5020601001')->pluck('id')->first(),//"Awards/Reward Expenses"
                ChartOfAccounts::where('code', '5021003000')->pluck('id')->first(),//"Extraordinary and Miscellaneous Expenses"
                ChartOfAccounts::where('code', '5021103002')->pluck('id')->first(),//"Consultancy Services"
                ChartOfAccounts::where('code', '5021202000')->pluck('id')->first(),//"Janitorial Services"
                ChartOfAccounts::where('code', '5021299099')->pluck('id')->first(),//"Other General Services"
                ChartOfAccounts::where('code', '5021199000')->pluck('id')->first(),//"Other Professional Services"
                ChartOfAccounts::where('code', '5021304000')->pluck('id')->first(),//"Repairs and Maintenance- Buildings and Other Structures"
                ChartOfAccounts::where('code', '5021305003')->pluck('id')->first(),//"Repairs and Maintenance-ICT Equipment"
                ChartOfAccounts::where('code', '5021305002')->pluck('id')->first(),//"Repairs and Maintenance - Office Equipment"
                ChartOfAccounts::where('code', '5021305007')->pluck('id')->first(),//"Repairs and Maintenance - Communication Equipment"
                ChartOfAccounts::where('code', '5021306000')->pluck('id')->first(),//"Repairs and Maintenance - Motor Vehicles"
                ChartOfAccounts::where('code', '5021307000')->pluck('id')->first(),//"Repairs and Maintenance-Furniture and Fixtures"
                ChartOfAccounts::where('code', '5021501001')->pluck('id')->first(),//"Taxes, Duties and Licenses"
                ChartOfAccounts::where('code', '5021502000')->pluck('id')->first(),//"Fidelity Bond Premiums"
                ChartOfAccounts::where('code', '5021503000')->pluck('id')->first(),//"Insurance Expenses"
                ChartOfAccounts::where('code', '5029901000')->pluck('id')->first(),//"Advertising Expenses"
                ChartOfAccounts::where('code', '5029902000')->pluck('id')->first(),//"Printing and Publication Expenses"
                ChartOfAccounts::where('code', '5029903000')->pluck('id')->first(),//"Representation Expenses"
                ChartOfAccounts::where('code', '5029904000')->pluck('id')->first(),//"Transportation and Delivery Expenses"
                ChartOfAccounts::where('code', '5029905001')->pluck('id')->first(),//"Rent - Building and Structures"
                ChartOfAccounts::where('code', '5029905003')->pluck('id')->first(),//"Rent- Motor Vehicles"
                ChartOfAccounts::where('code', '5029905004')->pluck('id')->first(),//"Rent- Equipment"
                ChartOfAccounts::where('code', '5029907099')->pluck('id')->first(),//"Other Subscription Expenses"
                ChartOfAccounts::where('code', '5029999099')->pluck('id')->first(),//"Other Maintenance & Operating Expenses"
            ],
            // 502,"Disaster Risk Reduction and Management - MOOE"
            '4' => [
                ChartOfAccounts::where('code', '5020101000')->pluck('id')->first(),//"Travelling Expenses - Local"
                ChartOfAccounts::where('code', '5020102000')->pluck('id')->first(),//"Travelling Expenses - Foreign"
                ChartOfAccounts::where('code', '5020201002')->pluck('id')->first(),//"Training Expenses"
                ChartOfAccounts::where('code', '5020301002')->pluck('id')->first(),//"Office Supplies Expenses"
                ChartOfAccounts::where('code', '5020305000')->pluck('id')->first(),//"Food Supplies Expenses"
                ChartOfAccounts::where('code', '5020309000')->pluck('id')->first(),//"Fuel, Oil and Lubricants Expenses"
                ChartOfAccounts::where('code', '5020399000')->pluck('id')->first(),//"Other Supplies and Materials Expenses"
                ChartOfAccounts::where('code', '5020402000')->pluck('id')->first(),//"Electricity Expenses"
                ChartOfAccounts::where('code', '5020501000')->pluck('id')->first(),//"Postage and Courier Services"
                ChartOfAccounts::where('code', '5020502001')->pluck('id')->first(),//"Telephone Expenses - Mobile"
                ChartOfAccounts::where('code', '5020502002')->pluck('id')->first(),//"Telephone Expenses - Landline"
                ChartOfAccounts::where('code', '5020503000')->pluck('id')->first(),//"Internet Subscription Expenses"
                ChartOfAccounts::where('code', '5020504000')->pluck('id')->first(),//"Cable, Satellite, Telegraph, and Radio Expenses"
                ChartOfAccounts::where('code', '5020601001')->pluck('id')->first(),//"Awards/Reward Expenses"
                ChartOfAccounts::where('code', '5021003000')->pluck('id')->first(),//"Extraordinary and Miscellaneous Expenses"
                ChartOfAccounts::where('code', '5021103002')->pluck('id')->first(),//"Consultancy Services"
                ChartOfAccounts::where('code', '5021202000')->pluck('id')->first(),//"Janitorial Services"
                ChartOfAccounts::where('code', '5021299099')->pluck('id')->first(),//"Other General Services"
                ChartOfAccounts::where('code', '5021199000')->pluck('id')->first(),//"Other Professional Services"
                ChartOfAccounts::where('code', '5021304000')->pluck('id')->first(),//"Repairs and Maintenance- Buildings and Other Structures"
                ChartOfAccounts::where('code', '5021305003')->pluck('id')->first(),//"Repairs and Maintenance-ICT Equipment"
                ChartOfAccounts::where('code', '5021305002')->pluck('id')->first(),//"Repairs and Maintenance - Office Equipment"
                ChartOfAccounts::where('code', '5021305007')->pluck('id')->first(),//"Repairs and Maintenance - Communication Equipment"
                ChartOfAccounts::where('code', '5021306000')->pluck('id')->first(),//"Repairs and Maintenance - Motor Vehicles"
                ChartOfAccounts::where('code', '5021307000')->pluck('id')->first(),//"Repairs and Maintenance-Furniture and Fixtures"
                ChartOfAccounts::where('code', '5021501001')->pluck('id')->first(),//"Taxes, Duties and Licenses"
                ChartOfAccounts::where('code', '5021502000')->pluck('id')->first(),//"Fidelity Bond Premiums"
                ChartOfAccounts::where('code', '5021503000')->pluck('id')->first(),//"Insurance Expenses"
                ChartOfAccounts::where('code', '5029901000')->pluck('id')->first(),//"Advertising Expenses"
                ChartOfAccounts::where('code', '5029902000')->pluck('id')->first(),//"Printing and Publication Expenses"
                ChartOfAccounts::where('code', '5029903000')->pluck('id')->first(),//"Representation Expenses"
                ChartOfAccounts::where('code', '5029904000')->pluck('id')->first(),//"Transportation and Delivery Expenses"
                ChartOfAccounts::where('code', '5029905001')->pluck('id')->first(),//"Rents - Building and Structures"
                ChartOfAccounts::where('code', '5029905003')->pluck('id')->first(),//"Rents- Motor Vehicles"
                ChartOfAccounts::where('code', '5029905004')->pluck('id')->first(),//"Rents- Equipment"
                ChartOfAccounts::where('code', '5029907099')->pluck('id')->first(),//"Other Subscription Expenses"
                ChartOfAccounts::where('code', '5029999099')->pluck('id')->first(),//"Other Maintenance & Operating Expenses"
            ],
            // 502,"QUICK RESPONSE FUND - MOOE"
            '5' => [
                ChartOfAccounts::where('code', '5020101000')->pluck('id')->first(),//"Travelling Expenses - Local"
                ChartOfAccounts::where('code', '5020102000')->pluck('id')->first(),//"Travelling Expenses - Foreign"
                ChartOfAccounts::where('code', '5020201002')->pluck('id')->first(),//"Training Expenses"
                ChartOfAccounts::where('code', '5020301002')->pluck('id')->first(),//"Office Supplies Expenses"
                ChartOfAccounts::where('code', '5020305000')->pluck('id')->first(),//"Food Supplies Expenses"
                ChartOfAccounts::where('code', '5020309000')->pluck('id')->first(),//"Fuel, Oil and Lubricants Expenses"
                ChartOfAccounts::where('code', '5020399000')->pluck('id')->first(),//"Other Supplies and Materials Expenses"
                ChartOfAccounts::where('code', '5020401000')->pluck('id')->first(),//"Water Expenses"
                ChartOfAccounts::where('code', '5020402000')->pluck('id')->first(),//"Electricity Expenses"
                ChartOfAccounts::where('code', '5020501000')->pluck('id')->first(),//"Postage and Courier Services"
                ChartOfAccounts::where('code', '5020502001')->pluck('id')->first(),//"Telephone Expenses - Mobile"
                ChartOfAccounts::where('code', '5020502002')->pluck('id')->first(),//"Telephone Expenses - Landline"
                ChartOfAccounts::where('code', '5020503000')->pluck('id')->first(),//"Internet Subscription Expenses"
                ChartOfAccounts::where('code', '5020504000')->pluck('id')->first(),//"Cable, Satellite, Telegraph, and Radio Expenses"
                ChartOfAccounts::where('code', '5020601001')->pluck('id')->first(),//"Awards/Reward Expenses"
                ChartOfAccounts::where('code', '5021499000')->pluck('id')->first(),//"Subsidies -Others"
                ChartOfAccounts::where('code', '5021202000')->pluck('id')->first(),//"Janitorial Services"
                ChartOfAccounts::where('code', '5021299099')->pluck('id')->first(),//"Other General Services"
                ChartOfAccounts::where('code', '5021199000')->pluck('id')->first(),//"Other Professional Services"
                ChartOfAccounts::where('code', '5021304000')->pluck('id')->first(),//"Repairs and Maintenance- Buildings and Other Structures"
                ChartOfAccounts::where('code', '5021305003')->pluck('id')->first(),//"Repairs and Maintenance-ICT Equipment"
                ChartOfAccounts::where('code', '5021305002')->pluck('id')->first(),//"Repairs and Maintenance - Office Equipment"
                ChartOfAccounts::where('code', '5021306000')->pluck('id')->first(),//"Repairs and Maintenance - Motor Vehicles"
                ChartOfAccounts::where('code', '5021307000')->pluck('id')->first(),//"Repairs and Maintenance-Furniture and Fixtures"
                ChartOfAccounts::where('code', '5021503000')->pluck('id')->first(),//"Insurance Expenses"
                ChartOfAccounts::where('code', '5029901000')->pluck('id')->first(),//"Advertising Expenses"
                ChartOfAccounts::where('code', '5029902000')->pluck('id')->first(),//"Printing and Publication Expenses"
                ChartOfAccounts::where('code', '5029903000')->pluck('id')->first(),//"Representation Expenses"
                ChartOfAccounts::where('code', '5029904000')->pluck('id')->first(),//"Transportation and Delivery Expenses"
                ChartOfAccounts::where('code', '5029905001')->pluck('id')->first(),//"Rent - Building and Structures"
                ChartOfAccounts::where('code', '5029905003')->pluck('id')->first(),//"Rent- Motor Vehicles"
                ChartOfAccounts::where('code', '5029905004')->pluck('id')->first(),//"Rent- Equipment"
                ChartOfAccounts::where('code', '5029907099')->pluck('id')->first(),//"Other Subscription Expenses"
                ChartOfAccounts::where('code', '5029999099')->pluck('id')->first(),//"Other Maintenance & Operating Expenses"
            ],
            // 506,"General Administration and Support - CO"
            '6' => [
                ChartOfAccounts::where('code', '5060407001')->pluck('id')->first(),//"Furnitures and Fixtures"
                ChartOfAccounts::where('code', '5060405099')->pluck('id')->first(),//"Other Machinery and Equipment"
                ChartOfAccounts::where('code', '5060405003')->pluck('id')->first(),//"Information and Communication Technology Eqpmt"
                ChartOfAccounts::where('code', '5060405002')->pluck('id')->first(),//"Office Equipmemt"
            ],
            // 506,"Civil Defense Enhancement - Capital Outlay"
            '7' => [
                ChartOfAccounts::where('code', '5060406001')->pluck('id')->first(),//"Transportation Equipment Outlay"
            ],
            // 506,"Disaster Risk Reduction and Management - CO"
            '8' => [
                ChartOfAccounts::where('code', '5060407001')->pluck('id')->first(),//"Furnitures and Fixtures"
                ChartOfAccounts::where('code', '5060405099')->pluck('id')->first(),//"Other Machinery and Equipment"
                ChartOfAccounts::where('code', '5060405003')->pluck('id')->first(),//"Information and Communication Technology Eqpmt"
                ChartOfAccounts::where('code', '5060405002')->pluck('id')->first(),//"Office Equipmemt"
                ChartOfAccounts::where('code', '5060407001')->pluck('id')->first(),//"Furnitures and Fixtures"
            ],
            '9' => [
                ChartOfAccounts::where('code', '5060407001')->pluck('id')->first(),//"Furnitures and Fixtures"
                ChartOfAccounts::where('code', '5060405099')->pluck('id')->first(),//"Other Machinery and Equipment"
                ChartOfAccounts::where('code', '5060405003')->pluck('id')->first(),//"Information and Communication Technology Eqpmt"
                ChartOfAccounts::where('code', '5060405002')->pluck('id')->first(),//"Office Equipmemt"
                ChartOfAccounts::where('code', '5060403000')->pluck('id')->first(),//"Infrastructure Outlay"
            ],
        ];
        print_r($fundChargeabilityClassAccount);
        $ChartOfAccountsId = array_keys($fundChargeabilityClassAccount);
        foreach ($ChartOfAccountsId as $coaId) {
            foreach ($fundChargeabilityClassAccount[$coaId] as $fcca) {
                FundChargeabilityClassAccount::firstOrCreate([
                    "coa_id" => $fcca,
                    "fcc_id" => $coaId
                ]);
            }
        }
        
       
    }
}
