<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOfSubPap extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['subpaps'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('list_of_sub_pap')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "List of Sub Pap {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
