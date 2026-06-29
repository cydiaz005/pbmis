<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FormPoe extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable=["suggested_pap_id","creator_id","pap_txt","geolocation","status_id","mfo_id","key_id","service_region_id","category_id","locker_user_id","thematic_area_cluster_id","stage_id","total","datetime_locked","locked","year","created_at","updated_at"];

    protected $appends=["formatted_created_at", "formatted_updated_at", "poe_code"];
    protected $dates = ['datetime_locked'];
    
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function categoryClass()
    {
        return $this->hasOne(FundChargeabilityClass::class, 'id', 'category_id');
    }

    public function fundChargeability()
    {
        return $this->categoryClass()->fundChargeability;
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
    public function userLocker()
    {
        return $this->hasOne(User::class, 'id', 'locker_user_id');
    }
    public function serviceRegion()
    {
        return $this->hasOne(ServiceRegion::class, 'id', 'service_region_id');
    }
    public function suggestedPap()
    {
        return $this->hasOne(ListOfPap::class, 'id', 'suggested_pap_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('poe')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => ucwords("Poe")." {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
    
    public function targetSectors()
    {
        return $this->hasMany(FormPoeTargetSector::class, 'poe_id', 'id');
    }
    public function thematicAreaClusters()
    {
        return $this->hasMany(FormPoeThematicAreasCluster::class, 'poe_id', 'id');
    }
    public function mfo()
    {
        return $this->hasOne(Mfo::class, 'id', 'mfo_id');
    }
    public function kdp()
    {
        return $this->hasOne(KdpKpKs::class, 'id', 'key_id');
    }
    public function thematicAreaCluster()
    {
        return $this->hasOne(ThematicAreasCluster::class, 'id', 'thematic_area_cluster_id');
    }
    public function poeTags()
    {
        return $this->hasMany(FormPoeTag::class, 'poe_id', 'id');
    }
    public function ppmp()
    {
        return $this->belongsTo(FormPpmp::class, 'id','poe_id');
    }
    public function ppmpOne()
    {
        return $this->hasOne(FormPpmp::class, 'poe_id','id');
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function returnable()
    {
        return $this->morphOne(ReturnedForm::class, 'returnable');
    }
    public function subpap()
    {
        return $this->hasMany(FormPoeSubPap::class, 'poe_id', 'id');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }
    public function getFormattedUpdatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }
    public function getPoeCodeAttribute()
    {
        if(@$this->attributes['id']){
            return "POE-".str_pad($this->attributes['id'], 5, '0', STR_PAD_LEFT);
        }
    }
    public function scopeTotalProgrammedBudget($query, $service_region_id)
    {
        $active_stage_id = Stage::where('active', '1')->first()->id;
        return $query->where('service_region_id', $service_region_id)
        ->where('stage_id', $active_stage_id)
        ->where('status_id', 2)
        ->whereHas('ppmpOne', function($q){
            $q->whereIn('funded', [2])
            ->where('status_id', 2);
        })
        // ->where('year', date('Y'))
        ->sum('total');
    }
}

