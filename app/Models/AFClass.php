<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AFClass extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('afclass')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "AF Class {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }


}

