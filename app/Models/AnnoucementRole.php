<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnoucementRole extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        "announcement_id",
        "role_id"
    ];
    protected $table = 'annoucement_roles';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('announcement_role')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Announcement Role {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
