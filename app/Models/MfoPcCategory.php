<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfoPcCategory extends Model
{
    use HasFactory;
    use LogsActivity;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('mfo_pc')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Major Final Output/Priority Class {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
