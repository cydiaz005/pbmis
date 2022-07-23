<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOpcItem extends Model
{
    use LogsActivity;
    use HasFactory;

    public function performanceMeasures()
    {
        return $this->belongsToMany(PerformanceMeasures::class,'form_opc_item_performance_measures','form_opc_item_id','pm_id')->withPivot('rating','target');
    }
    public function performanceTargets()
    {
        return $this->hasMany(PerformanceTargets::class);
    }
    public function priorityClass()
    {
        return $this->belongsTo(PriorityClass::class,'pc_id','id');
    }
    public function fundChargeability()
    {
        return $this->belongsTo(FundChargeability::class,'fc_id','id');
    }
    public function formPpmp()
    {
        return $this->hasOne(FormPpmp::class);
    }
    public function suggestedPap()
    {
        return $this->hasOne(ListOfPap::class, 'id', 'suggested_pap_id');
    }

    public function formOpc()
    {
        return $this->belongsTo(FormOpc::class);
    }
    
    public function mfo()
    {
        return $this->belongsTo(Mfo::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('form_opc_item')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Form Opc Item {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    } 

}
