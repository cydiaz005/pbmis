<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfoKey extends Model
{
    use HasFactory;
    use LogsActivity;

    public function kdp()
    {
        return $this->hasOne(KdpKpKs::class, 'id', 'key_id');
    }
    public function mfo()
    {
        return $this->hasOne(Mfo::class, 'id', 'mfo_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('mfo_key')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Major Final Output & Kdp/Kp/Ks Category {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
