<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable=[
        "receiver_id",
        "notif_type",
        "notifiable_type",
        "notifiable_id",
        "sender_type",
        "sender_id",
        "message",
    ];
    public function notifiable()
    {
        return $this->morphTo();
    }
    public function sender()
    {
        return $this->morphTo();
    }
    public function for()
    {
        return $this->morphTo();
    }
}
