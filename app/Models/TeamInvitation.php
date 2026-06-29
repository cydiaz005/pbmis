<?php

namespace App\Models;

use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\TeamInvitation as JetstreamTeamInvitation;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TeamInvitation extends JetstreamTeamInvitation
{

    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Jetstream::teamModel());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('team_inv')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Team Invitation {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
