<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceTargets extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable=["name"];

    public function formOpcItem()
    {
        return $this->belongsTo(FormOpcItem::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('pt')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Performance Target {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }


}
