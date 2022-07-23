<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundChargeability extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'type', 'accronym'];
    use LogsActivity;

    public function fundChargeabilityClass()
    {
        return $this->hasMany(FundChargeabilityClass::class, 'fc_id', 'id');
    }
    
    public function poe()
    {
        return $this->hasMany(FormPoe::class, 'poe_id', 'id');

    }

    public function categorize_forms()
    {
        return $this->fundChargeabilityClass()->groupBy('fc_id');
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('fc')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Fund Chargeability {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
