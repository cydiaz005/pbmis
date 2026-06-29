<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailFile extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'path',
        'name',
        'mail_id',
    ];

    public function size()
    {
        // return $this
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('mail_file')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Mail File {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
