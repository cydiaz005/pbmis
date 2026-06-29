<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnnoucementRole;
class Announcement extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        "content",
        "user_id"
    ];
    protected $table = 'announcements';

    public function announcement_send()
    {
        return $this->hasMany(AnnoucementRole::class, 'announcement_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('announcement')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Announcement {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    
}
