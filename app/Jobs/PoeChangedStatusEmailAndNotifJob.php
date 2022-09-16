<?php

namespace App\Jobs;

use App\Models\FormPoe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PoeChangedStatusEmailAndNotifJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_sender_id;
    public $poe_id;
    public $status_id;
    public $service_region_id;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_sender_id, $poe_id, $status_id)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $poe = FormPoe::where('id', $this->poe_id)->with(['creator', 'serviceRegion'])->first();
        $user_sender = User::find($this->user_sender_id);
        $creator = $poe->creator;
        $service_region = $poe->serviceRegion;
        $this->service_region_id = $service_region->id;

        $receiver = $this->getReceivers();

        $email_messages = [
            "2"=>"A Program Of Expenditures (POE) published by {$user_sender->name} from {$service_region->service_region} is currently waiting to be reviewed and approved in Project Procurement Management Plan (PPMP).", 
            "4"=>"{$user_sender->name} has rejected the Project Procurement Management Plan (PPMP) of {$service_region->service_region} based on the Program of Expenditures of {$creator->firstname}.  It is advised that {$creator->firstname} revise his or her submission in light of the reason for the return.",
            "5"=>"{$user_sender->name} has resolved the returned form, and the Project Procurement Management Plan is currently waiting for approval.",
        ];
        $notif_messages = [
            "2"=>"published a Program Of Expenditures (POE) from {$service_region->service_region}", 
            "4"=>"has rejected the Project Procurement Management Plan (PPMP) of {$service_region->service_region} based on the Program of Expenditures of {$creator->firstname}.  It is advised that {$creator->firstname} revise his or her submission in light of the reason for the return.",
            "5"=>"has resolved the returned form, and the Project Procurement Management Plan is currently waiting for approval.",
        ];


        Notify::create($receiver['ids'], [
            "type" => "user-published-poe",
            "notifiable" => ['App\Models\FormPpmp', $this->ppmp_id],
            "sender" => ['App\Models\User', $this->user_sender_id],
            "message" => "has Published POE and ready for review for PPMP.",
        ]);
        Mail::to($receiver['emails'])->send(new GeneralMailer([
            "subject" => "Published Program Of Expenditures (POE)",
            "template_data" => [
                "email_message"=>$email_messages[$this->status_id],
                "button"=>[
                    "redirect"=>env('APP_URL')."form/poe",
                    "text"=>"View POE",
                ]
            ],
        ]));    





    }

    public function getReceivers()
    {
        $receiver = [
            "emails"=>[],
            "ids"=>[],
        ];

        $service_region_id =  $this->service_region_id;

        $users = User::where("id", '!=',  $this->user_sender_id)
        ->where(function($q) use($service_region_id){
            $q->where("serreg_id", $service_region_id)
            ->whereHas("rol", function ($role) {
                $role->orWhere("role_id", 3);
            });
        })
        ->orWhereHas ("rol", function ($role) {
            $role->where("role_id", 1)
            ->orWhere("role_id", 2);
        })
        ->get();

        foreach ($users as  $value) {
            array_push($receiver['ids'], $value->id);
            array_push($receiver['emails'],  $value->email);
        }

        return $receiver;
    }
    
}
