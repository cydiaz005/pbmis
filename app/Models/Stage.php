<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ["name","accronym","active"];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('stage')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Stage {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    public function getNextStageIdAttribute()
    {
        $nextId = null;
        if(@$this->attributes['active'] == "1" && @$this->attributes['id']){
            $nextId = $this->attributes['id'] + 1;
            if($nextId > 3){
                $nextId = 1;
            }
        }
        return $nextId;
    }
}
