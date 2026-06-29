<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use LogsActivity;

    // public $timestamps = false;
    // protected $fillable = ['class_code','class','fc_code','type','category'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('category')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Category {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
