<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnnouncementEmail;
use App\Mail\PreRegistration;
use App\Mail\RolesandPermission;
use App\Mail\UserApprovalChangeRole;
use App\Mail\Mail as MailSupport;
use App\Mail\PublishedPPMP;
use App\Mail\PublishedPOE;
use App\Mail\PPMPEdited;
use App\Mail\PPMPReturned;
use App\Mail\PPMPResolved;
use App\Mail\PPMPClassificationReturned;
use App\Mail\PPMPClassification;
use App\Mail\FiscalStage;
use App\Mail\SpecialPriviledges;
use Throwable;

class EmailController extends Controller
{

    public function preRegistration($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PreRegistration([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "token" => $data['token'],
                "password" => $data['password']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }

    public function approvalChangeRole($data)
    {
        try {
            Mail::to($data['receiver'])->send(new UserApprovalChangeRole([
                "user" => $data["user"],
                "subject" => $data['subject'],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function emailAnnouncement($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],

            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function mail($data)
    {
        try {
            Mail::to($data['receiver'])->send(new MailSupport([

                "subject" => $data['subject'],
                "mail" => $data['mail'],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }

    public function forms($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "subject" => $data['subject'],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }

    public function publishedPOE($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PublishedPOE([

                "subject" => $data['subject'],
                "poe" => $data['poe']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function publishedPPMP($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PublishedPPMP([
                "subject" => $data['subject'],
                "ppmp" => $data['ppmp']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function ppmpEdited($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PPMPEdited([
                "subject" => $data['subject'],
                "poe" => $data['poe']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function ppmpReturned($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PPMPReturned([
                "subject" => $data['subject'],
                "poe" => $data['poe']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function ppmpResolved($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PPMPResolved([
                "ppmp" => $data["ppmp"],
                "subject" => $data['subject'],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function ppmpClassificationDue($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "listener" => $data['listener']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }

    public function ppmpClassificationReturned($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "listener" => $data['listener']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function ppmpClassificationApproval($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "listener" => $data['listener']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function budgetForm($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "listener" => $data['listener']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function ChangeActiveStage($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "listener" => $data['listener']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function fieldDependency($data)
    {
        try {
            Mail::to($data['receiver'])->send(new AnnouncementEmail([
                "user" => $data["user"],
                "subject" => $data['subject'],
                "listener" => $data['listener']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function rolesAndPermission($data)
    {
        try {
            Mail::to($data['receiver'])->send(new RolesandPermission([
                "role" => $data["role"],
                "subject" => $data['subject'],
                "creator" => $data["creator"],
                "message" => $data["message"],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function specialPriviledges($data)
    {
        try {
            Mail::to($data['receiver'])->send(new RolesandPermission([
                "user" => $data["user"],
                "subject" => $data['subject'],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function returnedPPMP($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PPMPClassificationReturned([
                "subject" => $data['subject'],
                "reason" => $data['reason'],
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public function fundedAndUnFundedSegregations($data)
    {
        try {
            Mail::to($data['receiver'])->send(new PPMPClassification([
                "subject" => $data['subject'],
                "type" => $data['type']
            ]));
        } catch (Throwable $e) {
            return response("failed to send Email", 200);
        }
    }
    public  function fiscalStage($data){
        try{
            Mail::to($data['receiver'])->send(new FiscalStage([
                "subject" => $data['subject'],
            ]));
        }catch(Throwable $e){
            return response("failed to send Email", 200);
        }
    }
    public function sendEmailSpecialPreviledges($data){
        try{
            Mail::to($data['receiver'])->send(new SpecialPriviledges([
                "subject" => $data['subject'],
                "priviledges" => $data['priviledges']
            ]));
        }catch(Throwable $e){
            return response("Failed to Send Email", 200);
        }
    }
}
