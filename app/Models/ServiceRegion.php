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
}
