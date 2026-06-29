<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FundChargeabilityClassAccount extends Model
{
    use HasFactory;
    protected $fillable = ['coa_id', 'fcc_id'];
    use LogsActivity;

    public function list($value)
    {
        return $value;
    }
    public function chartAccount()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'coa_id');
    }

    public function class()
    {
        return $this->hasOne(FundChargeabilityClass::class, 'id', 'coa_id');
    }
    

    public function FundChargeabilityClass(Type $var = null)
    {

    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('fc_class_account')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Fund Chargeability Class Account {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
