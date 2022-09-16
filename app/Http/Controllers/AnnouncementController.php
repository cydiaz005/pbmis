<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Spatie\Permission\Models\Role;
use App\Models\AnnoucementRole;
use App\Models\UserRoles;
use App\Models\Notification;
use App\Actions\Notify\Notify;
use App\Http\Controllers\EmailController;
use Auth;

use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
  public function view(){
    $roles = Role::where([
      ['name',"!=","Banned"],
  ])->get();
      return view("Announcement.index", ['roles' => $roles]);
  }
  public function createAnnouncementSend($announcementId, $role_id, $announcement ) {
    $annnouncementSend = new  AnnoucementRole();
    $annnouncementSend->announcement_id = $announcementId;
    $annnouncementSend->role_id  = $role_id;
    $annnouncementSend->save();

 
    $notificationNow = Announcement::where("id",$announcementId)
                        ->whereDate("start_date",Carbon::today())
                        ->first();
    $users = null;
    $recievers = [];      
   if($notificationNow){
                $users = UserRoles::where("role_id",$role_id )
                ->with(["user", "userdetails"])
                ->get();

          foreach ( $users as  $user) {

              if(@$user->user){
                array_push($recievers , @$user->user->email);
                $noticationExisted = Notification::where([
                  ['notifiable_id', $announcementId],
                  ["notif_type", "user-new-announcement"],
                  ["receiver_id", $user->user->id]
                ])->first();
                if( !$noticationExisted){
                  Notify::create([ $user->user->id], [
                  "type" =>"user-new-announcement",
                  "notifiable" => ['App\Models\Announcement',$announcementId],
                  "sender" => ['App\Models\User', Auth::user()->id],
                  "message" => "You Have A New Annoucement",
                  ]);
                  
                }

                
              }

          }
          $email = new EmailController();
              $email-> emailAnnouncement(
                  array(
                  "user" => Auth::user(),
                  "subject" => "New Announcement From Avails",
                  "announcement" => $announcement,
                  "receiver" => $recievers
                  )
              );
   } 
   
    return $users ;
  }
  public function create(Request $request){
    // $content = $request->all();
    $content = request("content");
    $roles = request("roles");
    $start_date = request("start_date");
    $subject = request("subject");
    $end_date = request("end_date");
    $announcement = new  Announcement() ;
    $announcement->content =  $content;
    $announcement->subject =  $subject;
    $announcement->start_date = Carbon::parse($start_date." ".Carbon::now()->toTimeString())->toDateTimeString();
    $announcement->end_date =  $end_date ? Carbon::parse($end_date)->toDateTimeString() : null; 
    $announcement->user_id =  Auth::user()->id;
   	$announcement->save();
   	$usersRoles = [];
    if($announcement){
        foreach($roles as $role){
          $users = $this->createAnnouncementSend($announcement->id, $role, $announcement);
          array_push($usersRoles,$users);
        }
    }
    return  $usersRoles;
  }
  public function update(Request $request){
      $update =  Announcement::where('id',request("id"));
      $announcement = $update->first(); 
       
      $update = $update->update(
        array('content' => request("content"),
              "subject" => request("subject"),
              "end_date" => Carbon::parse(request("end_date"))->toDateTimeString() ,
              "start_date" => Carbon::parse(request("start_date")." ".Carbon::now()->toTimeString())->toDateTimeString() 
         ));
      $roles = request("roles");
      
      $collection = AnnoucementRole::where('announcement_id', request("id"))->get(['id']);
      $deletedRoles = AnnoucementRole::destroy($collection->toArray());
     
      if( $deletedRoles){
        
        foreach($roles as $role){
          $this->createAnnouncementSend(request("id"), $role, $announcement);
        }
      }
     
      return ["update" => $update, "request" => request("id"), "content" =>  request("content")];
   
    }
  public function destroy(Request $request) {
    $delete = Announcement::find(request("id"));
    $delete->delete();
    return ["delete" =>$delete];

  }
  public function board(){
    $roles = Role::where([
        ['name',"!=","Banned"],
    ])->get();;
    return view("Announcement.board", ['roles' => $roles]);
  }
  public function boardPaginate(){
    $userRole = Auth::user()->roles->first();
    $announcement = Announcement::query();
  
    $announcement  =  $announcement                                       
		->whereDate("end_date", ">=",Carbon::today())
		->whereDate("start_date", "<=",Carbon::today()); 

    if( $userRole){
        $announcement = $announcement->whereRelation("announcement_send", function($role) use($userRole){
			$role->where("role_id",  $userRole->id);
        });
    }

    $announcement =  $announcement->orderBy('start_date', 'DESC')
		->with("announcement_send")
		->paginate(10);

    return ["announcement" =>   $announcement, "roles" =>  $userRole, "now" => Carbon::now()->format("h")];
  }
  public function getRolesAnnouncement($announcement_id){
    $roles = AnnoucementRole::where("announcement_id", $announcement_id)->get();
    return $roles;
  }
  public function   NotifyNow() {
   
   if(@Auth::user()){
    $userRole = Auth::user()->roles->first();
    $announcement = Announcement::query();
  
    
    $notifs = Notification::where([
      ["notif_type", "user-new-announcement"],
      ["notifiable_type", 'App\Models\Announcement' ],
      ["receiver_id", @Auth::user()->id],
    ])->get();
    $notif_ids=[];
    foreach ($notifs as $key => $value) {
        array_push( $notif_ids,$value->id );
    }
    $announcement  =  $announcement 
                        ->whereNotIn("id",$notif_ids )                                      
                        ->whereDate("start_date",  Carbon::today()); 
    if( $userRole){
        $announcement = $announcement->whereRelation("announcement_send", function($role) use($userRole){
                    $role->where("role_id",  $userRole->id);
        });
        $announcements =  $announcement->orderBy('start_date', 'DESC')
              ->with("announcement_send")->get();
        
          foreach ($announcements as $key => $value) {
              
              
            $noticationExisted = Notification::where([
              ['notifiable_id', $value->id],
              ["notif_type", "user-new-announcement"],
              ["receiver_id",@Auth::user()->id]
            ])->first();
            if(! $noticationExisted){
                // Notification::where([
                //   ["notif_type",  "user-new-announcement"], 
                //   ["notifiable_id", $value->id],
                //   ["receiver_id", Auth::user()->id],
                //   ["sender_id", $value->user_id]
                // ])->delete();

                Notify::create([ Auth::user()->id], [
                "type" =>"user-new-announcement",
                "notifiable" => ['App\Models\Announcement',$value->id],
                "sender" => ['App\Models\User', $value->user_id],
                "message" => "You Have A New Notification",
                ]);
                $email = new EmailController();
                $email-> emailAnnouncement(
                    array(
                    "user" => Auth::user(),
                    "subject" => "New Announcement From Avails",
                    "listener" => Auth::user(),
                    "announcement" => $value,
                    "receiver" => Auth::user()
                    )
                );
            }
          }
    }

      

  }
}
}
