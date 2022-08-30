<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotmentClass extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'class', 'accronym'];
    use LogsActivity;

    public function fundChargeabilityClass()
    {
        return $this->hasMany(FundChargeabilityClass::class, 'ac_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('allotment_class')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Allotment Class {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
    

}
