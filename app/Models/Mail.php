<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Mail extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'subject',
        'message',
        'sender_id',
        'status',
    ];

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
    public function recipients()
    {
        return $this->hasMany(UserInbox::class, 'mail_id', 'id');
    }
    public function files()
    {
        return $this->hasMany(MailFile::class, 'mail_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('mail')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Mail {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
