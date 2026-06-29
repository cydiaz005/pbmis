<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPoeTag extends Model
{
    use HasFactory;
    use LogsActivity;

    public function poe()
    {
        return $this->hasOne(FormPoe::class, 'id', 'poe_id');
    }
    public function papTag()
    {
        return $this->hasOne(PapTag::class, 'id', 'paptag_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('form_poe_tag')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Form POE Tag {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
