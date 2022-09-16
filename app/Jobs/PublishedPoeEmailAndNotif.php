<?php

namespace App\Jobs;

use App\Actions\Notify\Notify;
use App\Mail\GeneralMailer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishedPoeEmailAndNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user_id;
    public $user;
    public $ppmp_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $ppmp_id)
    {
        $this->user_id = $user_id;
        $this->ppmp_id = $ppmp_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user = User::find($this->user_id);
        $receiver = $this->getReceivers();
        
        
        Notify::create($receiver['ids'],         [
            "type" => "user-published-poe",
            "notifiable" => ['App\Models\FormPpmp', $this->ppmp_id],
            "sender" => ['App\Models\User', $this->user->id],
            "message" => "has Published POE and ready for review for PPMP.",
        ]);
        Mail::to($receiver['emails'])->send(new GeneralMailer([
            "subject" => "Published Program Of Expenditures (POE)",
            "template_data" => [
                "email_message"=>"A Program Of Expenditures (POE) published by ".$this->user->name." from ".$this->user->service_regions->service_region." is currently waiting to be reviewed and approved in Project Procurement Management Plan (PPMP).",
                "button"=>[
                    "redirect"=>env('APP_URL')."form/ppmp",
                    "text"=>"View PPMP",
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

        $service_region_id =  $this->user->serreg_id;

        $users = User::where("id", '!=',  $this->user_id)
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
