<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSentbox extends Model
{
    use HasFactory;
    use LogsActivity;


    protected $fillable = [
        'user_id',
        'mail_id',
        "status",
        "seen",
    ];

    public function mail()
    {
        return $this->hasOne(Mail::class, 'id', 'mail_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('user_sentbox')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "User sentbox {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
