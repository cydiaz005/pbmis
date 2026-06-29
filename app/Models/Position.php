<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    use LogsActivity;
    use HasFactory;
    protected $fillable = ['job_title'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('position')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Position {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
