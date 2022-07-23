<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapTag extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['tag'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('pap_tag')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "PAP Tag {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
