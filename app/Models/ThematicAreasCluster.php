<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThematicAreasCluster extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'thematic_area_cluster'
    ];
    public function poes()
    {
        return $this->hasMany(FormPoe::class, 'thematic_area_cluster_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('tac')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Thematic Areas Cluster {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
