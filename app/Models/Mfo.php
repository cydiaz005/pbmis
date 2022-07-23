<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Mfo extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['pc_id', 'desc'];
    protected $appends = ['total_budget'];

    public function priorityClass()
    {
        return $this->hasOne(PriorityClass::class, 'id','pc_id');
    }
    public function poes()
    {
        return $this->hasMany(FormPoe::class);
    }
    // public function totalBudget()
    // {
    //     return $this->hasMany(FormPoe::class)->groupBy('mfo_id')->selectRaw('sum(total) as budget');
    // }
    public function getTotalBudgetAttribute()
    {
        // return DB::table('poes')->where('mfo_id', $this->attributes['id'])->selectRaw('sum(total) as budget')->pluck('total')->first();
        // return $this->poes()->where('service_region_id', Auth::user()->serreg_id)->selectRaw('sum(total) as budget')->first()->budget;
        return $this->poes()->selectRaw('sum(total) as budget')->first()->budget;
    }
    public function poes_total()
    {
        return $this->poes()->select(DB::raw('sum(total) as total_budget'));
    }
    public function offices()
    {
        return $this->belongsToMany(Office::class,'office_mfos','mfo_id','office_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('mfo')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "Major Final Output {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }

    
}
