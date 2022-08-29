<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementMode extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['section','title'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('procurement_mode')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Procurement Mode {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    public function itemRequirement()
    {
        return $this->hasOne(FormPoeItemRequirement::class, 'procurement_mode_id');
    }
}
