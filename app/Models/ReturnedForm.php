<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedForm extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable=[
        "reason",
        "returner_id",
        "returnable_id",
        "returnable_type",
    ];
    public function returnable()
    {
        return $this->morphTo();
    }
    public function returner()
    {
        return $this->hasOne(User::class, 'id', 'returner_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('returned_form')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Returned Form {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
