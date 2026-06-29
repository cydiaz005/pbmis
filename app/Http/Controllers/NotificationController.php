<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;
class NotificationController extends Controller
{
    public function getNotifications()
    {

        $count = Notification::where([
            ['receiver_id', Auth::user()->id],
            ['seen', '0']
        ])->count();
        $paginationData = Notification::where('receiver_id', Auth::user()->id)
            ->with(['notifiable', 'sender', 'for'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return [
            "paginationData"=>$paginationData,
            "count"=>$count,
        ];
    }
    public function seenNotification(Request $request) {
        return Notification::where('id', $request->id)->update(['seen'=> '1']);
    }
    public function removeAllNotification(Request $request){
        $notif = Notification::where("receiver_id",  Auth::user()->id)->get(['id']);
        $remove =  Notification::destroy($notif->toArray());
        return  $remove ;
    }   
}