<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreloadedFile extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        "user_id",
        "path",
        "name",
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('preloaded_file')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Preloaded File {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
