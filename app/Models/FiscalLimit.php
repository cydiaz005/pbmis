<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceRegion;
class FiscalLimit extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['cat_id','amount','serreg_id','stage_id','year'];
    protected $appends = ['fiscal_limit_code'];
    public function serviceRegion()
    {
        return $this->belongsTo(ServiceRegion::class, 'serreg_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(FundChargeabilityClass::class, 'cat_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('fiscallimit')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Fiscal Limit {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
    public function getFormattedCreatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }
    public function getFormattedUpdatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }
    public function getFiscalLimitCodeAttribute()
    {
        if(@$this->attributes['id']){
            return "FL-".str_pad($this->attributes['id'], 5, '0', STR_PAD_LEFT);
        }
    }
}
