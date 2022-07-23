<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormPpmp extends Model
{
    use HasFactory;
    use LogsActivity;

    use SoftDeletes;
    protected $fillable=["funded","poe_id","status_id",];

    protected $dates = ['datetime_locked'];
    protected $appends = ['ppmp_code'];

    public function poe()
    {
        return $this->hasOne(FormPoe::class, 'id', 'poe_id');
    }
    public function getPpmpCodeAttribute()
    {
        if(@$this->attributes['id']){
            return "PPMP-".str_pad($this->attributes['id'], 5, '0', STR_PAD_LEFT);
        }
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('ppmp')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "PPMP {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
    public function returnable(){
        return $this->morphOne(ReturnedForm::class, 'returnable');
    }
    public function userLocker()
    {
        return $this->hasOne(User::class, 'id', 'locker_user_id');
    }
    
}
