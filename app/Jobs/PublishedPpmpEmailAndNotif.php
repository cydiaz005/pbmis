<?php

namespace App\Jobs;

use App\Actions\Notify\Notify;
use App\Mail\GeneralMailer;
use App\Models\FormPpmp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishedPpmpEmailAndNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $approver_id;
    public $ppmp_id;
    public $region_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($approver_id, $ppmp_id)
    {
        $this->approver_id = $approver_id;
        $this->ppmp_id = $ppmp_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ppmp = FormPpmp::where('id', $this->ppmp_id)->with('poe.creator.service_regions')->first();
        $this->region_id = $ppmp->poe->service_region_id;
        $approver = User::find($this->approver_id);
        $receiver = $this->getReceivers();
        
        $creator = $ppmp->poe->creator;
        
        Notify::create($receiver['ids'], [
            "type" => "user-published-ppmp",
            "notifiable" => ['App\Models\FormPpmp', $this->ppmp_id],
            "sender" => ['App\Models\User', $this->approver_id],
            "message" => "has Published PPMP.",
        ]);

        Mail::to($receiver['emails'])->send(new GeneralMailer([
            "subject" => "Project Procurement Management Plan (PPMP)",
            "template_data" => [
                "email_message"=>$approver->name." gave his approval to ".$creator->firstname."'s Project Procurement Management Plan (PPMP) for ".$creator->service_regions->service_region.". PPMP is now awaiting budget classification.",
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

        $service_region_id = $this->region_id;

        $users = User::where("id", '!=',  $this->approver_id)
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
