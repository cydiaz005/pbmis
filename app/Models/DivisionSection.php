<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionSection extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name','accronym'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('division_section')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Division/Section {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
