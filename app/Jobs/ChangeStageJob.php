<?php

namespace App\Jobs;

use App\Models\FiscalLimit;
use App\Models\FormPoe;
use App\Models\FormPoeItemRequirement;
use App\Models\FormPoeItemRequirementMonth;
use App\Models\FormPoeSubPap;
use App\Models\FormPpmp;
use App\Models\Setting;
use App\Models\Stage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Illuminate\Support\Str;

class ChangeStageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stage = Stage::where("active","1")->first()->append('next_stage_id');
        $next_stage_id = $stage->next_stage_id;
        $new_stage = Stage::find($next_stage_id);

        // delete 
        FormPoe::where('stage_id', $stage->id)
        ->whereYear('created_at', date('Y'))
        ->where('status_id', '!=', '2')
        ->delete();

        $poes = FormPoe::where('stage_id', $stage->id)
        ->whereYear('created_at', date('Y'))
        ->with('ppmp','subpap.itemRequirements.itemMonths')
        ->get();

        $fiscal_limits = FiscalLimit::where('stage_id', $stage->id)
        ->whereYear('created_at', date('Y'))
        ->get();

        $change_status_key = Str::random(16);
        $max = count($poes) + count($fiscal_limits);

        $this->prepareStatus(['key' => $change_status_key]);
        $this->setProgressMax($max);
        Setting::updateOrCreate(["key"=>"change_status_key"],["value"=>$change_status_key]);

        for ($i = 0; $i < count($poes); $i++) {
            $poe = $poes[$i];
            $new_poe = FormPoe::firstOrCreate([
                "suggested_pap_id" => $poe->suggested_pap_id,
                "creator_id" => $poe->creator_id,
                "pap_txt" => $poe->pap_txt,
                "geolocation" => $poe->geolocation,
                "status_id" => 1,
                "mfo_id" => $poe->mfo_id,
                "key_id" => $poe->key_id,
                "service_region_id" => $poe->service_region_id,
                "category_id" => $poe->category_id,
                "thematic_area_cluster_id" => $poe->thematic_area_cluster_id,
                "stage_id" => $new_stage->id,
                "total" => $poe->total,
            ]);

            FormPpmp::where('poe_id', $poe->id)->whereNull('funded')->delete();

            foreach ($poe->subpap as $subpap) {
                $new_subpap = FormPoeSubPap::firstOrCreate([
                    "poe_id" =>   $new_poe->id,
                    "quarter_target_id" =>   $subpap->quarter_target_id,
                    "subpap_txt" =>   $subpap->subpap_txt,
                    "suggested_subpap_id" =>   $subpap->suggested_subpap_id,
                ]);
                foreach ($subpap->itemRequirements as $ir) {
                    $new_item_requirement = FormPoeItemRequirement::firstOrCreate([
                        "subpap_id" => $new_subpap->id,   
                        "account_id" => $ir->account_id,   
                        "itemreq_txt" => $ir->itemreq_txt,   
                        "no_of_days" => $ir->no_of_days,  
                        "per_capita_cost" => $ir->per_capita_cost,   
                        "procurement_mode_id" => $ir->procurement_mode_id,   
                        "qty_pax" => $ir->qty_pax,   
                        "suggested_itemreq_id" => $ir->suggested_itemreq_id,   
                        "total" => $ir->total,   
                        "unit" => $ir->unit,   
                        "unit_id" => $ir->unit_id,   
                    ]);

                    foreach ($ir->itemMonths as $item) {
                    $item_req_month = FormPoeItemRequirementMonth::firstOrCreate([
                            "item_req_id" => $new_item_requirement->id,
                            "amount" => $item->amount,
                            "month" => $item->month,
                            "qty" => $item->qty,
                        ]);;
                    };
                }
            }
            $this->incrementProgress(1);
        }

        for ($i = 0; $i < count($fiscal_limits); $i++) {
            $fiscal_limit = $fiscal_limits[$i];
            
            FiscalLimit::firstOrCreate([
                'cat_id' => $fiscal_limit->cat_id,
                'amount' => $fiscal_limit->amount,
                'serreg_id' => $fiscal_limit->serreg_id,
                'stage_id' => $new_stage->id,
            ]);

            $this->incrementProgress(1);
        }

        $this->setOutput(['total' => $max]);


        $stage->active="0";
        $stage->update();

        $new_stage->active="1";
        $new_stage->update();
        Setting::updateOrCreate(["key"=>"changing_stage"],["value"=>0]);
    }
}
