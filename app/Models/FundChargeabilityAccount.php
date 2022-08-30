<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundChargeabilityAccount extends Model
{
    use HasFactory;

    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('fc_account')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Fund chargeability account {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }


}
