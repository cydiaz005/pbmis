<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\UserRoles;
use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
      'profile_photo_url',  'firstname','middlename','lastname','gender','ext','email', 'password','divsec_id','pos_id','serreg_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
      //   "namex"
    ];
    public  function rol(){
        return  $this->hasOne(UserRoles::class, "model_id", "id");
        
    }
    // public function getNamexAttribute()
    // {
    //     return $this->attributes['firstname']." ".$this->attributes['lastname'];
    // }
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('user')
            -> logAll()
            -> logExcept(['password'])
            -> setDescriptionForEvent(fn(string $eventName) => ucwords("User")." {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    public function service_regions()
    {
        return $this->hasOne(ServiceRegion::class, 'id', 'serreg_id');
    }
    public function division_section()
    {
        return $this->hasOne(DivisionSection::class, 'id', 'divsec_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function approved_users()
    {
        return $this->hasMany(User::class, 'approver_id');
    }

    public function profilePhoto()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function poes()
    {
        return $this->hasMany(FormPoe::class, 'creator_id', 'id')->withTrashed();
    }
    public function getStatusValueAttribute()
    {
        return @$this->attributes['status'] ? ["Pending", "Approved", "Suspended"][@$this->attributes['status']] : null;
    }
}
