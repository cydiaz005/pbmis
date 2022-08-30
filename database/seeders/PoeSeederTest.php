<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FormPoe;
use App\Models\FormPpmp;
use App\Models\ReturnedForm;
use App\Models\FormStatus;
use App\Models\MfoKey;
use App\Models\PapTag;
use App\Models\ListOfPap;
use App\Models\ServiceRegion;
use App\Models\ThematicAreasCluster;
use App\Models\FundChargeabilityClass;
use App\Models\ListOfSubPap;
use App\Models\FormPoeTag;
use App\Models\FormPoeSubPap;
use App\Models\FormPoeItemRequirement;
use App\Models\FormPoeItemRequirementMonth;
use App\Models\Stage;

use Faker;
 


class PoeSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $iterations = rand(10,20);
        // $iterations = 1; //

        $year=[2019, 2021, 2022];

        $user = User::all();
        $mfoKey = MfoKey::all();
        $serviceRegion = ServiceRegion::all();
        $fundChargeabilityClass = FundChargeabilityClass::all();
        $listOfSubPap = ListOfSubPap::all();
        $stage = Stage::all();
        echo "\n Total iteration: ".$iterations;
        echo "\n Total POE: ".($iterations * count($serviceRegion))."\n";
        for ($iteration=1; $iteration <= $iterations; $iteration++) {  
            echo "\n Running iteration: ".$iteration."\n";
            foreach ($serviceRegion as $sr) {
                echo "\t\t\033[01;93mCreating POE for " .$sr->service_region. "\033[0m\n";
                $stage_id = $stage[rand(0, count($stage) - 1)];
                // $stage_id = $stage[1]; //temporary
                
                $statuses = [1,2,4,5];
                $status = $statuses[rand(0, count($statuses) - 1)];
                // $status = 2; //temporarys

                $category = $fundChargeabilityClass[rand(0, count($fundChargeabilityClass)-1)];
                $faker = Faker\Factory::create();
                $created_at = $year[rand(0, (count($year) - 1))]."-".rand(1,12).rand(1,27);
                $poe=[
                    "pap_id"=>rand(1, 57),
                    "creator_id"=>$user[rand(1, count($user)-1)]->id,
                    "geolocation"=>$faker->address,
                    "status"=>$status,
                    "mfo_id"=>$mfoKey[rand(0, count($mfoKey)-1)]->mfo_id,
                    "kdp_id"=>$mfoKey[rand(0, count($mfoKey)-1)]->key_id,
                    "region_id"=>$sr->id,
                    "category_id"=>$category->id,
                    "thematic_area_cluster"=>rand(1, 5),
                    "total"=>0,
                    "stage_id" => strval($stage_id->id),
                    "target_sectors"=>[],
                    "form_related"=>[],
                    "subpaps"=>[],
                    "created_at"=>$created_at,
                    "updated_at"=>$created_at,
                ];
                $subpap_count = rand(2, 5); 
                // $subpap_count = 2; //temporary
                for ($i=0; $i < $subpap_count; $i++) { 
                    $subpap = [
                        "subpap_id"=>$listOfSubPap[rand(0, count($listOfSubPap)-1)]->id,
                        "subpap_quarter_target"=>rand(1, 16),
                        "item_reqs"=>[],
                    ]; 
                    $item_req_count = rand(2, 5);
    
                    for ($x=0; $x < $item_req_count; $x++) { 
                        $item_reqs = [
                            "item_account_code_id"=>rand(1, 25),
                            "item_req_id"=>rand(1, 38),
                            "item_cost"=>rand(1000, 100000),
                            "unit_id"=>rand(1,3),
                            "item_procurement_mode"=>rand(1,17),
                            "item_qty_pax"=>rand(1, 10),
                            "item_days"=>rand(2, 5),
                            "item_months"=>[],
                        ];
                        $item_req_total = $item_reqs["item_cost"] * $item_reqs["item_days"] * $item_reqs["item_qty_pax"];
                        $poe["total"] += $item_req_total;
                        $item_req_month_count = rand(1, 12);
                        $amount = $item_req_total / $item_req_month_count;
                        for ($y=0; $y < $item_req_month_count; $y++) { 
                            $item_months = [
                                "month"=>rand(1, 12),
                                "amount"=>$amount,
                                "qty"=>rand(1, 3),
                            ];
                            array_push($item_reqs["item_months"], $item_months);
                        }
                        array_push($subpap["item_reqs"], $item_reqs);
                    }
                    array_push($poe["subpaps"], $subpap);
                }
                if($status == 4 || $status == 5){
                    $poe["reason_poe"] = [
                        "returner_id"=>$user[rand(1, count($user)-1)]->id,
                        "reason"=>$faker->text,
                    ];
                }
                $this->save($poe);
                echo "\t\t\033[01;95mDone POE: " .$sr->service_region. "\033[0m\n";
            }
            echo "\033[01;92mDone: " . $iteration. "/" . $iterations . "\033[0m\n";
        }
        
    }

    public function save($data)
    {
        $formPoe = new FormPoe;
        $formPoe->suggested_pap_id = $data["pap_id"];
        $formPoe->creator_id = $data["creator_id"];
        $formPoe->pap_txt = NULL;
        $formPoe->geolocation = $data["geolocation"];
        $formPoe->status_id = $data["status"];
        $formPoe->stage_id = $data["stage_id"];
        $formPoe->mfo_id = $data["mfo_id"];
        $formPoe->key_id = $data["kdp_id"];
        $formPoe->service_region_id = $data["region_id"];
        $formPoe->category_id = $data["category_id"];
        $formPoe->thematic_area_cluster_id = $data["thematic_area_cluster"];
        $formPoe->total = $data["total"];
        $formPoe->save();

        $target_sectors = $data["target_sectors"];
        foreach ($target_sectors as $target_sector) {
            $formPoeTargetSector = new FormPoeTargetSector;
            $formPoeTargetSector->poe_id = $formPoe->id;
            $formPoeTargetSector->target_sector_id = $target_sector;
            $formPoeTargetSector->save();
        }
        
        $poe_tags = $data["form_related"];
        foreach ($poe_tags as $poe_tag) {
            $formPoeTag = new FormPoeTag;
            $formPoeTag->poe_id = $formPoe->id;
            $formPoeTag->paptag_id = $poe_tag;
            $formPoeTag->save();
        }
        
        $subpaps = $data["subpaps"];
        foreach ($subpaps as $subpap) {
            $formPoeSubPap = new FormPoeSubPap;
            $formPoeSubPap->poe_id = $formPoe->id;
            $formPoeSubPap->suggested_subpap_id = $subpap['subpap_id'];
            $formPoeSubPap->subpap_txt = NULL;
            $formPoeSubPap->quarter_target_id = $subpap['subpap_quarter_target'];
            $formPoeSubPap->save();

            $item_reqs = $subpap['item_reqs'];

            foreach ($item_reqs as $item_req) {
                $formPoeItemRequirement = new FormPoeItemRequirement;
                $formPoeItemRequirement->subpap_id = $formPoeSubPap->id;
                $formPoeItemRequirement->account_id = $item_req['item_account_code_id'];
                $formPoeItemRequirement->suggested_itemreq_id = $item_req['item_req_id'];
                $formPoeItemRequirement->itemreq_txt = NULL;
                $formPoeItemRequirement->per_capita_cost = $item_req['item_cost'];
                $formPoeItemRequirement->unit_id = $item_req['unit_id'];
                $formPoeItemRequirement->unit = NULL;
                $formPoeItemRequirement->procurement_mode_id = $item_req['item_procurement_mode'];
                $formPoeItemRequirement->qty_pax = $item_req['item_qty_pax'];
                $formPoeItemRequirement->no_of_days = $item_req['item_days'];
                $formPoeItemRequirement->save();

                $item_req_months = $item_req['item_months'];

                foreach ($item_req_months as $item_req_month) {
                    $formPoeItemRequirementMonth = new FormPoeItemRequirementMonth;
                    $formPoeItemRequirementMonth->item_req_id = $formPoeItemRequirement->id;
                    $formPoeItemRequirementMonth->month = $item_req_month['month'];
                    $formPoeItemRequirementMonth->amount = $item_req_month['amount'];
                    $formPoeItemRequirementMonth->qty = $item_req_month['qty'];
                    $formPoeItemRequirementMonth->save();
                }
            }
        }

        if($formPoe->status_id == 4 || $formPoe->status_id == 5){
            ReturnedForm::create([
                "reason"=>$data["reason_poe"]["reason"],
                "returner_id"=>$data["reason_poe"]["returner_id"],
                "returnable_id"=>$formPoe->id,
                "returnable_type"=>"App\Models\FormPoe",
            ]);
        }
        else if($formPoe->status_id == 2){
            $formPpmp = new FormPpmp;
            $formPpmp->poe_id = $formPoe->id;
            $formPpmp->status_id = rand(2,3);
            $formPpmp->funded = strval(rand(0,1));
            $formPpmp->enduser_unit = "Test";
            $formPpmp->save();
        }
    }
}
