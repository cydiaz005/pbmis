<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOfItemRequirement extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['ireq'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('list_of_item_requirement')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "List of Item Requirement {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

}
