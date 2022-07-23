<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriorityClass extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['class','accronym'];


    public function mfos()
    {
        return $this->hasMany(Mfo::class,'pc_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('priority_class')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Priority Class {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }


}
