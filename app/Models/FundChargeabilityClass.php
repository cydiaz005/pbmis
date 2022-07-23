<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FundChargeabilityClass extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['ac_id','fc_id'];

    public function allotmentClass()
    {
       return $this->hasOne(AllotmentClass::class, 'id', 'ac_id');
    }
    public function fundChargeability()
    {
       return $this->hasOne(FundChargeability::class, 'id', 'fc_id');
    }
    
    public function fiscalLimit()
    {
       return $this->hasMany(FiscalLimit::class, 'cat_id', 'id');
    }
  
    public function poes()
    {
       return $this->hasMany(FormPoe::class, 'category_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('fc_class')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Fund Chargeability Class {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
