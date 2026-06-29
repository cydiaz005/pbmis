<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapTag extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['tag'];


    public function formPoeTag()
    {
        return $this->hasOne(FormPoeTag::class, 'paptag_id', 'id');
    }
    public function poe()
    {
        return $this->belongsToMany(FormPoe::class, 'form_poe_tags', 'paptag_id','poe_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('pap_tag')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "PAP Tag {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
