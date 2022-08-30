<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPoeTargetSector extends Model
{
    use HasFactory;
    use LogsActivity;

    public function targetSector()
    {
        return $this->hasOne(TargetSector::class, 'id', 'target_sector_id');
    }
    public function formPoe()
    {

        return $this->hasMany(FormPoe::class, 'id','poe_id');

    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('form_poe_target_sector')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "POE Target Sector {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
