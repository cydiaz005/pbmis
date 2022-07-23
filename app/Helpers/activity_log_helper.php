<?php

use App\Models\AllotmentClass;
use App\Models\ChartOfAccounts;
use App\Models\FormPoeItemRequirement;
use App\Models\FormStatus;
use App\Models\FundChargeability;
use App\Models\FundChargeabilityClass;
use App\Models\KdpKpKs;
use App\Models\ListOfItemRequirement;
use App\Models\ListOfPap;
use App\Models\ListOfSubPap;
use App\Models\Mfo;
use App\Models\Office;
use App\Models\PapTag;
use App\Models\ProcurementMode;
use App\Models\QuarterTarget;
use App\Models\ServiceRegion;
use App\Models\Stage;
use App\Models\ThematicAreasCluster;
use App\Models\Units;
use App\Models\User;

//multi purpose function for 2 strings
function stringedCorrectly($str1, $str2)
{
    if (!$str1 && !$str2) return "none";
    if (!$str2) return $str1;
    if (!$str1) return $str2;
    return $str1 . " - " . $str2;
}

//set unified prop inside setters
function setProperties($item, $type = "atrributes")
{
    if ($type == "old" && isset($item->properties->old))
        return json_decode(json_encode($item->properties->old), true);
    return json_decode(json_encode($item->properties->attributes), true);
}

//mutate item from activity log using all the function below
function mutateItemFields($item)
{
    if (isset($item->properties->attributes))
        $item = mutateProps($item);
    if (isset($item->properties->old))
        $item = mutateProps($item, "old");

    return $item;
}

//mutate attribute or old props
function mutateProps($item, $type = "attributes")
{
    $item = setCreatorFullName($item, $type);
    $item = setLockerFullName($item, $type);
    $item = setSuggestedPaps($item, $type);
    $item = setStatus($item, $type);
    $item = setMFO($item, $type);
    $item = setCategory($item, $type);
    $item = setServiceRegion($item, $type);
    $item = setThematicAreasCluster($item, $type);
    $item = setKdpKpKs($item, $type);
    $item = setStage($item, $type);
    $item = setSubPap($item, $type);
    $item = setPapTag($item, $type);
    $item = setPoe($item, $type);
    $item = setChartAccount($item, $type);
    $item = setSuggestedItemReq($item, $type);
    $item = setUnit($item, $type);
    $item = setProcurementMode($item, $type);
    $item = setItemReq($item, $type);
    $item = setSuggestedSubPap($item, $type);
    $item = setQuarterTarget($item, $type);
    $item = setFunded($item, $type);
    $item = setOffice($item, $type);

    return $item;
}

function setCreatorFullName($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["creator_id"])) return $item;

    $user = User::find($properties['creator_id']);
    if (!$user) return $item;

    if ($type == "attributes")
        $item->properties->attributes->creator = $user->firstname . " " . $user->middlename . " " .  $user->lastname;
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->creator = $user->firstname . " " . $user->middlename . " " .  $user->lastname;

    return $item;
}

function setLockerFullName($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["locker_user_id"])) return $item;

    $user = User::find($properties['locker_user_id']);
    if (!$user) return $item;

    if ($type == "attributes")
        $item->properties->attributes->locker = $user->firstname . " " . $user->middlename . " " .  $user->lastname;
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->locker = $user->firstname . " " . $user->middlename . " " .  $user->lastname;

    return $item;
}

function setSuggestedPaps($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["suggested_pap_id"])) return $item;

    $pap = ListOfPap::find($properties['suggested_pap_id']);
    if (!$pap) return $pap;

    if ($type == "attributes")
        $item->properties->attributes->pap = stringedCorrectly($pap->paps, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->pap = stringedCorrectly($pap->paps, null);

    return $item;
}

function setStatus($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["status_id"])) return $item;

    $status = FormStatus::find($properties['status_id']);
    if (!$status) return $item;

    if ($type == "attributes")
        $item->properties->attributes->status = stringedCorrectly($status->status, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->status = stringedCorrectly($status->status, null);

    return $item;
}

function setMFO($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["mfo_id"])) return $item;

    $mfo = Mfo::find($properties['mfo_id']);
    if (!$mfo) return $item;

    if ($type == "attributes")
        $item->properties->attributes->mfo = stringedCorrectly($mfo->desc, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->mfo = stringedCorrectly($mfo->desc, null);

    return $item;
}

function setCategory($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["category_id"])) return $item;

    $fund_charge_class = FundChargeabilityClass::find($properties['category_id']);
    if (!$fund_charge_class) return $item;

    if (!$fund_charge_class) {
        if ($type == "attributes")
            $item->properties->attributes->category = "none";
        else if ($type == "old" && isset($item->properties->old))
            $item->properties->old->category = "none";

        return $item;
    }

    $fund_charge = FundChargeability::find($fund_charge_class->fc_id);
    $allotment = AllotmentClass::find($fund_charge_class->ac_id);
    if (!$fund_charge || !$allotment) return $item;

    $category = stringedCorrectly($fund_charge->accronym, $allotment->accronym);

    if ($type == "attributes")
        $item->properties->attributes->category = $category;
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->category = $category;

    return $item;
}

function setServiceRegion($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["service_region_id"])) return $item;

    $service_region = ServiceRegion::find($properties['service_region_id']);
    if (!$service_region) return $item;

    if ($type == "attributes")
        $item->properties->attributes->service_region = stringedCorrectly($service_region->service_region, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->service_region = stringedCorrectly($service_region->service_region, null);

    return $item;
}

function setThematicAreasCluster($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["thematic_area_cluster_id"])) return $item;

    $thematic_area_cluster = ThematicAreasCluster::find($properties['thematic_area_cluster_id']);
    if (!$thematic_area_cluster) return $thematic_area_cluster;

    if ($type == "attributes")
        $item->properties->attributes->thematic_area_cluster = stringedCorrectly($thematic_area_cluster->thematic_area_cluster, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->thematic_area_cluster = stringedCorrectly($thematic_area_cluster->thematic_area_cluster, null);

    return $item;
}

function setKdpKpKs($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["key_id"])) return $item;

    $kdp_kp_ks = KdpKpKs::find($properties['key_id']);
    if (!$kdp_kp_ks) return $item;

    if ($type == "attributes")
        $item->properties->attributes->kdp_kp_ks = stringedCorrectly($kdp_kp_ks->desc, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->kdp_kp_ks = stringedCorrectly($kdp_kp_ks->desc, null);

    return $item;
}

function setStage($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["stage_id"])) return $item;

    $stage = Stage::find($properties['stage_id']);
    if (!$stage) return $item;

    if ($type == "attributes")
        $item->properties->attributes->stage = stringedCorrectly($stage->name, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->stage = stringedCorrectly($stage->name, null);

    return $item;
}

function setSubPap($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["subpap_id"])) return $item;

    $subpap = ListOfSubPap::find($properties['subpap_id']);
    if (!$subpap) return $item;

    if ($type == "attributes")
        $item->properties->attributes->subpap = stringedCorrectly($subpap->subpaps, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->subpap = stringedCorrectly($subpap->subpaps, null);

    return $item;
}

function setPapTag($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["paptag_id"])) return $item;

    $paptag = PapTag::find($properties['paptag_id']);
    if (!$paptag) return $item;

    if ($type == "attributes")
        $item->properties->attributes->paptag = stringedCorrectly($paptag->tag, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->paptag = stringedCorrectly($paptag->tag, null);

    return $item;
}

function setPoe($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["poe_id"])) return $item;

    if ($type == "attributes")
        $item->properties->attributes->poe_id = stringedCorrectly("POE-0000" . $properties["poe_id"], null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->poe_id = stringedCorrectly("POE-0000" . $properties["poe_id"], null);

    return $item;
}

function setChartAccount($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["account_id"])) return $item;

    $chart_account = ChartOfAccounts::find($properties['account_id']);
    if (!$chart_account) return $item;

    if ($type == "attributes")
        $item->properties->attributes->account_code = stringedCorrectly($chart_account->code, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->account_code = stringedCorrectly($chart_account->code, null);

    return $item;
}

function setSuggestedItemReq($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["suggested_itemreq_id"])) return $item;

    $item_req = ListOfItemRequirement::find($properties['suggested_itemreq_id']);
    if (!$item_req) return $item;

    if ($type == "attributes")
        $item->properties->attributes->suggested_item_requirement = stringedCorrectly($item_req->ireq, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->suggested_item_requirement = stringedCorrectly($item_req->ireq, null);

    return $item;
}

function setUnit($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["unit_id"])) return $item;

    $unit = Units::find($properties['unit_id']);
    if (!$unit) return $item;

    if ($type == "attributes")
        $item->properties->attributes->unit = stringedCorrectly($unit->unit, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->unit = stringedCorrectly($unit->unit, null);

    return $item;
}

function setProcurementMode($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["procurement_mode_id"])) return $item;

    $procurement_mode = ProcurementMode::find($properties['procurement_mode_id']);
    if (!$procurement_mode) return $item;

    if ($type == "attributes")
        $item->properties->attributes->procurement_mode = stringedCorrectly($procurement_mode->section . " - " . $procurement_mode->title, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->procurement_mode = stringedCorrectly($procurement_mode->section . " - " . $procurement_mode->title, null);

    return $item;
}

function setItemReq($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["item_req_id"])) return $item;

    $form_poe_item_requirement = FormPoeItemRequirement::with(["suggestedItemRequirement"])->find($properties['item_req_id']);
    if (!$form_poe_item_requirement) return $item;

    if ($type == "attributes")
        $item->properties->attributes->item_requirement = stringedCorrectly($form_poe_item_requirement->suggestedItemRequirement->ireq, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->item_requirement = stringedCorrectly($form_poe_item_requirement->suggestedItemRequirement->ireq, null);

    return $item;
}

function setSuggestedSubPap($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["suggested_subpap_id"])) return $item;

    $suggested_subpap = ListOfSubPap::find($properties['suggested_subpap_id']);
    if (!$suggested_subpap) return $item;

    if ($type == "attributes")
        $item->properties->attributes->suggested_subpap = stringedCorrectly($suggested_subpap->subpaps, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->suggested_subpap = stringedCorrectly($suggested_subpap->subpaps, null);

    return $item;
}

function setQuarterTarget($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["quarter_target_id"])) return $item;

    $quarter_target = QuarterTarget::find($properties['quarter_target_id']);
    if (!$quarter_target) return $item;

    if ($type == "attributes")
        $item->properties->attributes->quarter_target = stringedCorrectly($quarter_target->quarter_target, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->quarter_target = stringedCorrectly($quarter_target->quarter_target, null);

    return $item;
}

function setFunded($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["funded"])) return $item;

    if ($type == "attributes")
        $item->properties->attributes->fund_status = stringedCorrectly(intval($properties["funded"]) == 1 ? "Funded" : "Unfunded", null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->fund_status = stringedCorrectly(intval($properties["funded"]) == 1 ? "Funded" : "Unfunded", null);

    return $item;
}

function setOffice($item, $type = "attributes")
{
    $properties = setProperties($item, $type);
    if (!isset($properties["office_id"])) return $item;

    $office = Office::find($properties['office_id']);
    if (!$office) return $item;

    if ($type == "attributes")
        $item->properties->attributes->office = stringedCorrectly($office->name, null);
    else if ($type == "old" && isset($item->properties->old))
        $item->properties->old->office = stringedCorrectly($office->name, null);

    return $item;
}
