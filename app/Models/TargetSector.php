<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSector extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['sector'];
    public function formPoeTargetSector()
    {
        # code...
        return $this->hasMany(FormPoeTargetSector::class, 'target_sector_id','id');

    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('target_sector')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Target Sector {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
