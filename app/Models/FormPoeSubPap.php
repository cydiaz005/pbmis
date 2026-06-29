<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPoeSubPap extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable=[
        'poe_id',
        'quarter_target_id',
        'subpap_txt',
        'suggested_subpap_id',
    ];

    public function itemRequirements()
    {
        return $this->hasMany(FormPoeItemRequirement::class, 'subpap_id', 'id');
    }

    public function itemRequirementSum()
    {
        return $this->itemRequirements()->with('itemMonthSum');
    }

    public function poe()
    {
        return $this->hasOne(FormPoe::class, 'id','poe_id')->withTrashed();
    }

    public function suggestedSubPap()
    {
        return $this->hasOne(ListOfSubPap::class, 'id', 'suggested_subpap_id');
    }
    public function quarterTarget()
    {
        return $this->hasOne(QuarterTarget::class, 'id', 'quarter_target_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('form_poe_sub_pap')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Form POE Subpap {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
