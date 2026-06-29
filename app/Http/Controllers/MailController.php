<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mail;
use App\Models\MailFile;
use App\Models\MailReply;
use App\Models\UserInbox;
use App\Models\UserSentbox;
use App\Models\PreloadedFile;
use App\Models\Trashmail;
use App\Actions\Notify\Notify;
use App\Http\Controllers\EmailController;

use Auth;

class MailController extends Controller
{
    public function getInboxMails(Request $request)
    {
        $inbox = UserInbox::query();
        $query = $request->search_query;
        if($query){
            $inbox =  $inbox->where(function($q) use($query ){
                $q ->whereRelation("mail", function($qw) use($query){
                   
                    $qw->where(function($mailx) use($query){
                        $mailx->where("subject","like" , "%".$query."%");
                        $mailx->orWhere("message","like","%".$query."%");
                    
                    });
                    $qw->orwhere(function($sender) use($query){
                            $sender->whereHas("sender", function($user) use($query){
                                $user->where("email", "like", "%".$query."%");
                            });
                      
                    });
                    
                });
            });
    
        }
        $inbox =$inbox->where('user_id', Auth::user()->id)
        ->with(['mail.sender', 'mail.files'])
        ->where("status","0")
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        $inbox->prepend(strtotime('now'), 'server_time');
        $inbox->prepend('inbox','type');
        return $inbox;
    }
    public function getSentMails(Request $request)
    {   $sentbox = UserSentbox::query();
        $query = $request->search_query;
        if($query){
           
            $sentbox = $sentbox->where(function($q) use($query ){
                    $q -> whereRelation("mail", function($qw) use($query){
                       
                        $qw->where(function($mailx) use($query){
                            $mailx->where("subject","like" , "%".$query."%");
                            $mailx->orWhere("message","like","%".$query."%");
                        
                        });
                        $qw->orWhere(function($userList) use($query){
                            $userList-> whereRelation("recipients", function($recieptient) use($query){
                                $recieptient->whereHas("user", function($user) use($query){
                                    $user->where("email", "like", "%".$query."%");
                                });
                            });
                        });
                        
                    });
            } );
          
        }
        $sentbox = $sentbox->where('user_id', Auth::user()->id)
        ->where("status", "0")
        ->with(['mail.sender', 'mail.files', "mail.recipients"])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        $sentbox->prepend(strtotime('now'), 'server_time');
        $sentbox->prepend('sentbox','type');
        return $sentbox;
    }
    public function getReplies($id)
    {
        $replies = MailReply::where('mail_id', $id)
        ->with('user')  
        ->paginate(5);
        $replies->prepend(strtotime('now'), 'server_time');
        return $replies;
    }
    public function mailInbox(){
        return view('pages.mail.inbox');
    }
    
    public function mailSent(){
        return view('pages.mail.sent');
    }
    
    public function mailDraft(){
        return view('pages.mail.draft');
    }
    
    public function mailTrash(){
        return view('pages.mail.trash');
    }
    
    public function mailCompose(){
        $files = PreloadedFile::where("user_id", Auth::user()->id)->get();
        // dd($files);
        if(@$files){
            for ($i=0; $i < count($files); $i++) { 
                PreloadedFile::where('id', $files[$i]->id)->delete();
                Storage::delete($files[$i]->path);
            }
        }
        return view('pages.mail.compose');
    }
    public function readSentMail($id){ 
        $mail = UserSentbox::where([['user_id', Auth::user()->id], ['mail_id', $id],  ["status", '0']])
        ->with(['mail.sender','mail.files', "mail.recipients"]);
        $sentMail = $mail->first();
        if(!@$sentMail){
            abort(404);
        }
        if($sentMail->seen == '1'){
            $mail->update(['seen'=>'0']);
        }
        
        if(@$sentMail->mail->files){
            for ($i=0; $i < count($sentMail->mail->files); $i++) {
                $sentMail->mail->files[$i]['size'] = $this->convertByte(Storage::size($sentMail->mail->files[$i]->path));
            }
        }
        return view('pages.mail.read-mail', 
        [
            'mail'=>$sentMail->mail, 'date'=>$sentMail->created_at->format('d M. Y g:i A'),
            "type" => "sentbox",
            "inboxId" => $sentMail->id,
        ]);
    }
    public function readInboxMail($id){ 
        $mail = UserInbox::where([['user_id', Auth::user()->id], ['mail_id', $id], ["status", '0']])
        ->with(['mail.sender',  'mail.files', "mail.recipients"]);
        
        $inboxMail = $mail->first();
        if(!@$inboxMail){
            abort(404);
        }
        if($inboxMail->seen == '1'){
            $mail->update(['seen'=>'0']);
        }
        
        if(@$inboxMail->mail->files){
            for ($i=0; $i < count($inboxMail->mail->files); $i++) {
                $inboxMail->mail->files[$i]['size'] = $this->convertByte(Storage::size($inboxMail->mail->files[$i]->path));
            }
        }
        
        return view('pages.mail.read-mail', 
        [   'mail'=>$inboxMail->mail, 
            'date'=>$inboxMail->created_at->format('d M. Y g:i A'),
            "type" => "inbox",
            "inboxId" => $inboxMail->id,
            "recieptient" => ""]);
    }
    public function readSentDraft($id){
        $mail = UserSentbox::where([['user_id', Auth::user()->id], ['mail_id', $id]])
        ->with(['mail.sender', 'mail.recipients.user', 'mail.files', "mail.recipients"]);
        $sentMail = $mail->first();
        if(!@$sentMail){
            abort(404);
        }
        if($sentMail->seen == '1'){
            $updateToSeen = UserSentbox::find(@$sentMail->id);
            $updateToSeen->seen = '0';
            $updateToSeen->update();
        }
        
        if(@$sentMail->mail->files){
            for ($i=0; $i < count($sentMail->mail->files); $i++) {
                $sentMail->mail->files[$i]['size'] = $this->convertByte(Storage::size($sentMail->mail->files[$i]->path));
            }
        }
        return view('pages.mail.read-mail', [
            'mail'=>$sentMail->mail, 
            'date'=> $sentMail->created_at->format('d M. Y g:i A'),
            "type"=> "draft",
            ]
        );
           
    }
    public function readSentTrash($id){
        $trashshableData  = Trashmail::query();
       
        $trashshableData = $trashshableData->where([["user_id",  Auth::user()->id], ["id", $id]]);
        $trashshableData->with(['trashable.mail.sender', 'trashable.mail.recipients.user', 'trashable.mail.files', "trashable.mail.recipients"]);
        $trashshableData = $trashshableData->first();
        $updateTrash = Trashmail::find($id);
        if($updateTrash){
            $updateTrash->seen = '0';
            $updateTrash->update();
        }
        if(!@$trashshableData){
            abort(404);
        }
        $mail = $trashshableData->trashable->mail;
        if($mail->files){
            for ($i=0; $i < count($mail->files); $i++) {
               $mail->files[$i]['size'] = $this->convertByte(Storage::size($mail->files[$i]->path));
            }
        }

         return view('pages.mail.read-mail', 
        [
            'mail'=> $mail, 
            'date'=>$trashshableData->created_at->format('d M. Y g:i A'),
            "trashableType" => $trashshableData->trashable_type,
            "trashable_id" =>$trashshableData->trashable_id,
            "type"=>"trash",
            'trashable' => $trashshableData,
            "inboxId" => $trashshableData->id
        ]);
    }
    public function mailReadMail($id){  
        $mail = Mail::where('id', $id)
        ->with(['sender', 'recipients.user'])
        ->with('files')
        ->first();
        
        if(@$mail->files){
            for ($i=0; $i < count($mail->files); $i++) {
                $mail->files[$i]['size'] = $this->convertByte(Storage::size($mail->files[$i]->path));
            }
        }
        return view('pages.mail.read-mail', ['mail'=>$mail]);
    }
    
    public function searchMail(Request $request){
        $query = $request->input('query');
        $except = $request->input('except');
        $results = User::select('id', 'email', 'firstname', 'middlename','lastname', "profile_photo_path as img")
        ->whereNotIn('id', $except)
        ->where('id', '!=', Auth::user()->id)
        ->where("status", '1')
        ->where(function($q) use ($query) {
            $q->where('firstname', 'like', '%'.$query.'%');
            $q->orWhere('lastname', 'like', '%'.$query.'%');
            $q->orWhere('middlename', 'like', '%'.$query.'%');
            $q->orWhere('email', 'like', '%'.$query.'%');
        })
        ->take(5)
        ->get();
        return $results;
    }
    public function saveReply(Request $request)
    {
        $mail  = Mail::where([["sender_id", $request->input("sender_id")], ['id', $request->input("mail_id")]])->first();
        if(!$mail){
            return;
        }
        if($mail->sender_id != Auth::user()->id){
            UserInbox::updateOrCreate([
                "user_id" => $request->input("sender_id"),
                "mail_id" => $request->input("mail_id"),
            ]);    
        }
        if($request->input("type")){
            if($request->input("type") == "trash"){
                if($request->input("trashable_id") && $request->input("trashable") 
                && $request->input("trashId")){
                   
                    if($request->input("trashable") == "AppModelsUserSentbox"){
                       $sentBox = UserSentbox::find( $request->input("trashable_id"));
                       if($sentBox){
                        $sentBox->status = '0';
                        $sentBox->update();
                       }
                    }else{
                        $sentInBox = UserInbox::find( $request->input("trashable_id"));
                        if($sentInBox){
                         $sentInBox->status = '0';
                         $sentInBox->update();
                        }
                    }
                    Trashmail::where("id", $request->input("trashId"))->delete();
                }
            }
        }
        $reply = MailReply::create([
            "user_id" => Auth::user()->id,
            "mail_id" => $request->input("mail_id"),
            "message" => $request->input("message"),
        ]);
        return $reply->created_at->format('d M. Y g:i A');
    }
    public function saveMail(Request $request)
    {
        $ids = $request->input("ids");
        $file_paths = $request->input("addedFiles");
        $mail = Mail::create([
            "subject" => $request->input("subject"),
            "message" => $request->input("message"),
            "sender_id" => Auth::user()->id,
        ]);
        if(@$mail->id){
            $users = User::whereIn("id",$ids )->get();

            if(!$request->input("status")){
                foreach ($ids as $id) {
                    UserInbox::create([
                        "user_id" => $id,
                        "mail_id" => $mail->id,
                        
                    ]);
                }
            }
           
            UserSentbox::create([
                "user_id" => Auth::user()->id,
                "mail_id" => $mail->id,
                "status" => ($request->input("status")) ?: '0',
            ]);

            if(@$file_paths){
                foreach ($file_paths as $file_path) {
                    $preUploadedfiles = PreloadedFile::where("path", $file_path);
                    $files = $preUploadedfiles->first();
                    if(@$files){
                        MailFile::create([
                            "path"=>$files->path,
                            "name"=>$files->name,
                            "mail_id" => $mail->id,
                        ]);
                        $preUploadedfiles->delete();
                    }
                }
            }
            if(!$request->input("status")){
                Notify::create($ids,  [
                    "type" => "user-new-mail",
                    "notifiable" => ['App\Models\Mail',@$mail->id],
                    "sender" => ['App\Models\User', Auth::user()->id],
                    "message" => "send new mail",
                ]);
                $users_email = [];
                $user_ids = [];
                foreach ($users as $key => $user) {
                    array_push($users_email, $user->email);
                    array_push($user_ids, $user->id);
                }    
                $email = new EmailController();
                $email->mail(
                    array(
                        "receiver" => $users_email,
                        "mail" => $mail,
                        "subject" => "New Mail Support ( OCD PBMIS )"
                    )
                );
            }
           
        }
    }
    public function preUploadFiles(Request $request)
    {
        $dir = 'mail/files';
        if(!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        $path = $request->file('file')->store($dir);
        $preloadedFile = PreloadedFile::create([
            "user_id" => Auth::user()->id,
            "path" => $path,
            "name" => $request->file('file')->getClientOriginalName(),
        ]);
        return $path;
    }
    public function removeFiles(Request $request)
    {
        PreloadedFile::where([["user_id", Auth::user()->id],["path", $request->input('path')]])->delete();
        Storage::delete($request->input('path'));
    }
    public function previewFile(Request $request, $path)
    {
        $path = "mail/files/".$path;
        if(!Storage::exists($path)){
            abort(404);
        }
        return Storage::response($path);
    }

    public function convertByte($bytes){
        $num = 1024;
        $size = $bytes / $num;
        $unit = "KB";

        if($size > $num){
            $size = $size / $num;
            $unit = "MB";
        }
        if($size > $num){
            $size = $size / $num;
            $unit = "GB";
        }
        $rounded = round($size, 2);

        return $rounded." ".$unit;
    }
    public function getDraftMail(Request $request){
        $sentbox = UserSentbox::query();
        $query = $request->search_query;
        if($query){
           
            $sentbox = $sentbox->where(function($q) use($query ){
                $q -> whereRelation("mail", function($qw) use($query){
                   
                    $qw->where(function($mailx) use($query){
                        $mailx->where("subject","like" , "%".$query."%");
                        $mailx->orWhere("message","like","%".$query."%");
                    
                    });
                    $qw->orWhere(function($userList) use($query){
                        $userList-> whereRelation("recipients", function($recieptient) use($query){
                            $recieptient->whereHas("user", function($user) use($query){
                                $user->where("email", "like", "%".$query."%");
                            });
                        });
                    });
                    
                });
        } );
          
        }
        $sentbox = $sentbox->where('user_id', Auth::user()->id)
        ->where("status", "1")
        ->with(['mail.sender', 'mail.files', "mail.recipients"])
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        $sentbox->prepend(strtotime('now'), 'server_time');
        $sentbox->prepend('sentbox','type');
        return $sentbox;
    }
    public function getTrashMail(Request $request){
        $inbox = UserInbox::where('user_id', Auth::user()->id)
        ->with(['mail.sender', 'mail.files', "mail.recipients"])
        ->where("status", "2")
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        $inbox->prepend(strtotime('now'), 'server_time');
        $inbox->prepend('inbox','type');
        return $inbox;
    }
    public function deleteMail(Request $request){
         $destroy =    Mail::destroy(request('ids'));
         return (request('ids'));
    }
    public function searchBySearch(Request $request){
        $query = $request->input('query');
        $mail = UserInbox::query();
        $mail = $mail->where('user_id', Auth::user()->i)
                     ->with(['mail.sender'])
                     ->where("mail.message", $query)
                     ->orWhere("mail.sender.email", $query)->paginate(10);
        return $mail;
        
    }
    public function draftToCompose($id){
        $mail = UserSentbox::where([['user_id', Auth::user()->id], ['mail_id', $id]])
        ->with(['mail.sender', 'mail.recipients.user', 'mail.files', "mail.recipients"]);
        $sentMail = $mail->first();
        if($sentMail->seen == '1'){
            $updateToSeen = UserSentbox::find(@$sentMail->id);
            $updateToSeen->seen = '0';
            $updateToSeen->update();
        }
        if(!@$sentMail){
            abort(404);
        }        
        if(@$sentMail->mail->files){
            for ($i=0; $i < count($sentMail->mail->files); $i++) {
                $sentMail->mail->files[$i]['size'] = $this->convertByte(Storage::size($sentMail->mail->files[$i]->path));
            }
        }
        return view('pages.mail.compose', ["draftmail" => $sentMail]); 
    }
    public function updateToSent(Request $request,   $sentbox_id, $mailId){
        $ids = $request->input("ids");
        $file_paths = $request->input("addedFiles");
      
        foreach ($ids as $id) {
            $ifAlreadySended = UserInbox::query();
            $ifAlreadySended = $ifAlreadySended->Where("mail_id","=", $mailId);
            $ifAlreadySended->delete();
        }
        foreach ($ids as $id) {   
            $ifAlreadySended = UserInbox::query();
            $ifAlreadySended = $ifAlreadySended->where("user_id", "=", $id)->Where("mail_id",$mailId)->first();
            if(!($ifAlreadySended)){
                UserInbox::create([
                    "user_id" => $id,
                    "mail_id" => $mailId,          
                ]);
            };
        }
        if(@$file_paths){
            foreach ($file_paths as $file_path) {
                $preUploadedfiles = PreloadedFile::where("path", $file_path);
                $files = $preUploadedfiles->first();
                if(@$files){
                    MailFile::create([
                        "path"=>$files->path,
                        "name"=>$files->name,
                        "mail_id" => $mailId,
                    ]);
                    $preUploadedfiles->delete();
                }
            }
        }
        $mailUpdate = Mail::find($mailId);
        $mailUpdate->subject = $request->input("subject");
        $mailUpdate->message = $request->input("message");
        $mailUpdate->update();
        $userSentBox = UserSentbox::find($sentbox_id);
        $userSentBox->status = '0';
        $userSentBox->seen = '1';
        $userSentBox->update();
    
        return $mailId;
    }
    public function deleteTrashData(Request $request){
     
        $ids = request("ids");
        foreach($ids as $id){
          $trash =   Trashmail::find($id);

            if($trash){
                
            }
          if(@$trash->trashable_type == "App\\Models\\UserSentbox"){
              $sentbox =   UserSentbox::find($trash->trashable_id);
                if( $sentbox){
                    if($this->mailDeletor( @$sentbox->mail_id)){
                        @$sentbox->delete();
                     }
                }
             
          }else if(@$trash->trashable_type == "App\\Models\\UserInbox"){
            $sentbox =   UserInbox::find(@$trash->trashable_id);
            if($sentbox){
                if($this->mailDeletor( @$sentbox->mail_id)){
                    @$sentbox->delete();
                 }
            }
           

          }
          @$trash->delete();
        }
        return (request('ids'));
    }
    public function deleteMailFile($id){
             $remove = MailFile::where('id', $id)->delete();
             return  $remove;
    }
    public function mailDeletor($id){
        $mailSentExist = UserSentbox::where("mail_id", $id)->exists();
        $mailInboxExist = UserInbox::where("mail_id", $id)->exists();
        if( !$mailSentExist && !$mailInboxExist){
            $mailFile =  MailFile::where("mail_id",$id )->get();
            foreach($mailFile as $mail){
                $this->deleteMailFile( $mail->id);
            }
            Mail::destroy($id) ;
            return true;
        }
        return false;
    }   
    public function recount(Request $request){
        $type  = $request->type;
        if($type == "sender"){
          $sender =  UserSentbox::where([['user_id', Auth::user()->id], ['seen', '1'],  ['status', "0"]])->count();
          return $sender;
        }else if($type === "draft"){
                $draft = UserSentbox::where([['user_id', Auth::user()->id],['seen', '1'],  ['status', "1"]])->count();
                return  $draft ;
        }else if($type === "inbox"){
            $inbox = UserInbox::where([['user_id', Auth::user()->id], ['seen', '1'], ['status', "0"]])->count();
            return $inbox;
        }
        return $type;
    }
    
    public function recoverTrash(Request $request){
        $typeof = $request->type;
        $trashId = $request->trash_id;
        $trashableId = $request->trashable_id;
        if($typeof == "sentbox"){
            $update = UserSentbox::find($trashableId);
            if( $update){
                $update->status = '0';
                $update->update();
            }
        }else{
            $update = UserInbox::find( $trashableId);
            if( $update){
                $update->status = '0';
                $update->update();
            }
        }
        $trash = Trashmail::where([["user_id",  Auth::user()->id], ["id", $trashId]]);
        if( $trash){
            $trash->delete(); 
        }
        return ["request" => $request->all()];
    }
}
