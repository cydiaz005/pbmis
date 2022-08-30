<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserInbox extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'mail_id',
    ];
    protected $appends =[
            'user'
    ];
    public function mail()
    {
        return $this->hasOne(Mail::class, 'id', 'mail_id');
    }
    public function user()
    {   

        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getUserAttribute(){
        return $this->user()->first();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('user_inbox')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "User Inbox {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
