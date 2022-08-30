<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRegion extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['service_region','accronym','co','fillable'];

    public function fiscalLimit()
    {
        return $this->hasMany(FiscalLimit::class, 'serreg_id', 'id');
    }
    public function poes()
    {
        return $this->hasMany(FormPoe::class, 'service_region_id', 'id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('service_region')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Service Region {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    public function getProcurementCountAttribute()
    {
        // return FormPoe::whereHas('ppmp', function($q){
        //     $q->where('funded', '1');
        // })
        // ->where('service_region_id', $this->attributes['id'])
        // ->whereHas('subpap.itemRequirements', function($q){
        //     $q->groupBy('procurement_mode_id');
        // })->count();

        return FormPoeItemRequirement::whereHas('ppmp', function($q){
            $q->where('funded', '1');
        })
        ->where('service_region_id', $this->attributes['id'])
        ->whereHas('subpap.itemRequirements', function($q){
            $q->groupBy('procurement_mode_id');
        })->count();
    }
    public function getPoeCountAttribute()
    {
        return FormPoe::count();
    }
}
