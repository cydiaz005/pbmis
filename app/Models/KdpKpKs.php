<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KdpKpKs extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['desc'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('kdpkpks')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Kdp/Kp/Ks {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    public function poes()
    {
        return $this->hasMany(FormPoe::class, 'key_id', 'id');
    }

    public function keyPoeTotal()
    {
        return $this->poes()->groupBy('key_id');
        // return $this->poes->groupBy('key_id')->sum('total');

    }
    
    


}
