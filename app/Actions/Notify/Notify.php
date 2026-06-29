<?php

namespace App\Actions\Notify;

use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class Notify
{
    public static $receivers = [];
    public static $type;
    public static $notifiable;
    public static $sender;
    public static $for;
    protected static $_instance;

    public static function create($receivers, $data)
    {
        $forSend = [];
        static::$_instance = new Notify;
        for ($i=0; $i < count($receivers); $i++) { 
            $new_data =  self::$_instance->getData($receivers[$i], $data);
            $notif = Notification::create($new_data);
            array_push($forSend, $notif);
        }
    }
    public static function send()
    {
        static::$_instance = new Notify;

        $forSend = [];
        $receivers = self::$receivers;
        for ($i=0; $i < count($receivers); $i++) { 
            $data =  self::$_instance->getData($receivers[$i]);
            $notif = Notification::create($data);
            array_push($forSend, $notif);
        }
        self::$_instance = null;
        return $forSend;
    }
    public static function receiver($user_ids)
    {
        self::$receivers = $user_ids;
        return static::getself();
    }
    public static function type($notif_type)
    {
        self::$type = $notif_type;
        return static::getself();
    }
    public static function notifiable($arr)
    {
        self::$notifiable = $arr;
        return static::getself();
    }
    public static function sender($arr)
    {
        self::$sender = $arr;
        return static::getself();
    }
    public static function for($arr)
    {
        self::$for = $arr;
        return static::getself();
    }
    public function getData($receiver_id, $data)
    {
        $d['receiver_id']=$receiver_id;
        $d['notif_type']=$data['type'];
        $d['notifiable_id']=@$data['notifiable'] ? @$data['notifiable'][1]:null;
        $d['notifiable_type']=@$data['notifiable'] ? @$data['notifiable'][0]:null;
        $d['sender_id']=@$data['sender'] ? @$data['sender'][1]:null;
        $d['sender_type']=@$data['sender'] ? @$data['sender'][0]:null;
        $d['message']=@$data['message'];
        // $d['for_id']=@$data['for'] ? @$data['for'][1]:null;
        // $d['for_type']=@$data['for'] ? @$data['for'][0]:null;
        return $d;
    }
    protected static function getself()
    {
        if (static::$_instance === null) 
        {
            static::$_instance = new Notify;
        }
        return static::$_instance;
    }
}
