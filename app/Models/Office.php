<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    use LogsActivity;

    public function mfos()
    {
        return $this->belongsToMany(Mfo::class,'office_mfos','office_id','mfo_id');
    }

    public function serviceRegions()
    {
        return $this->hasMany(ServiceRegion::class,'office_id','id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('poe')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Office {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
