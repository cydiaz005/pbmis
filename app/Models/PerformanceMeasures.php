<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceMeasures extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['name', 'legend'];


    public function formOpcItems()
    {
        return $this->belongsToMany(FormOpcItem::class,'form_opc_item_performance_measures','pm_id','form_opc_item_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('pm')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Performance Measure {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
