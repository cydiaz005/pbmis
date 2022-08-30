<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KdpkpksMfoCategory extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['kdpkpks_id','mfo_id'];


    public function kdpkpks()
    {
       return $this->hasOne(KdpKpKs::class, 'id', 'kdpkpks_id');
    }

    public function mfo()
    {
       return $this->hasOne(Mfo::class, 'id', 'mfo_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('kdpkpks_mfo')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Kdp/Kp/Ks MFO Category {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
    

}
