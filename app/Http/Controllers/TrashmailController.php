<?php

namespace App\Http\Controllers;

use App\Models\Trashmail;
use Illuminate\Http\Request;
use App\Models\UserInbox;
use App\Models\UserSentbox;
use Auth;

class TrashmailController extends Controller
{

    public function deleteToTrashSentBox(Request $request){
        $ids = request("ids");
        $type = request("type");
        $types = ["sentbox" => "App\\Models\\UserSentbox", "inbox" => "App\\Models\\UserInbox"];
        $create = [];
        foreach($ids as $id){
          
                $cr =   Trashmail::create([
                'user_id' => Auth::user()->id,
                'trashable_id' => $id ,
                'trashable_type' => $types[$type],
            ]);
            if( $type == "sentbox"){
                $update = UserSentbox::find($id);
                if( $update){
                    $update->status = '2';
                    $update->update();
                }
            
            }else{
                $update = UserInbox::find( $id);
                if( $update){
                    $update->status = '2';
                    $update->update();
                }
               
              
               
            }
                array_push($create, $cr);
        }
        return  $ids;
    }
    public function viewTrash(Request $request){

        $trash = Trashmail::query(); 
        $query = $request->search_query;
        if($query)
        {
            $trash = $trash->where(function($mailsR) use($query){
                $mailsR->whereRelation("trashable", function($qt) use($query){
                    $qt->whereRelation("mail", function($qw) use($query){
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
                        $qw->orwhere(function($sender) use($query){
                            $sender->whereHas("sender", function($user) use($query){
                                $user->where("email", "like", "%".$query."%");
                                });
                            });
                    });
                });
               
            });
        }
        $trash = $trash->where("user_id",  Auth::user()->id)
        ->with(["trashable.mail", "trashable.mail.recipients", "trashable.mail.sender", "trashable.mail.files"])
        ->paginate(10);
        $trash->prepend(strtotime('now'), 'server_time');
        $trash->prepend('trash','type');
        return $trash;
    }
   
}
