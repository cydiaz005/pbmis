<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Setting;
use Livewire\Component;

class ChangeStagePercentage extends Component
{

    public $percentage = 0;
    public $done = false;
    public function render()
    {
        $key = \App\Models\Setting::where("key","change_status_key")->first();
        if(@$key){
            $data = \Imtigger\LaravelJobStatus\JobStatus::where("key",$key->value)->whereNull('output')->first();
            if($data){
                $this->percentage = $data->progress_percentage;
            }
            else{
                $this->done = !Setting::changingStage();
            }
        }
        return view('livewire.jobs.change-stage-percentage');
    }
}
