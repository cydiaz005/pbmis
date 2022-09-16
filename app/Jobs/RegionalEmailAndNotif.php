<?php

namespace App\Jobs;

use App\Mail\GeneralMailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegionalEmailAndNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $region_id;
    public $user_id;
    public $mail_data;
    public $notif_data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($region_id, $user_id, $mail_data, $notif_data)
    {
        $this->region_id = $region_id;
        $this->user_id = $user_id;
        $this->mail_data = $mail_data;
        $this->notif_data = $notif_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $receiver = [
            "emails"=>[],
            "ids"=>[],
        ];

        $users = User::where("id", '!=',  $this->user_id)
        ->where("serreg_id", $this->region_id)
        ->whereHas("rol", function ($role) {
            $role->where("role_id", 1);
            $role->orWhere("role_id", 2);
            $role->orWhere("role_id", 3);
        })->get();

        foreach ($users as  $value) {
            array_push($receiver['ids'], $value->id);
            array_push($receiver['emails'],  $value->email);
        }

        Notify::create($receiver['ids'], $this->notif_data);
        Mail::to($receiver['emails'])->send(new GeneralMailer($this->mail_data));    
    }
}
