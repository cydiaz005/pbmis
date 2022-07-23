<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FormOpc extends Model
{
    use HasFactory;
    protected $fillable=["locked"];
    use LogsActivity;
    protected $appends=["opc_code"];

    public function formOpcItems()
    {
        return $this->hasMany(FormOpcItem::class);
    }
    public function serviceRegion()
    {
        return $this->hasOne(ServiceRegion::class, 'id', 'serreg_id');
    }
    public function suggestedPap()
    {
        return $this->hasOne(ListOfPap::class, 'id', 'suggested_pap_id');
    }
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
    public function getBudgetAttribute()
    {
        $semester_dates = [
            "1"=>[
                "start" => "01",
                "end" => "06",
            ],
            "2"=>[
                "start" => "07",
                "end" => "12",
            ]
        ];

        
        $formPpmp = FormPpmp::query();
        
        $formPpmp = $formPpmp->join('form_poes', 'form_ppmps.poe_id', '=', 'form_poes.id')
        ->select(DB::raw('SUM(total) budget'))
        ->where([
            ['form_ppmps.status_id', 2], 
            ['stage_id', Stage::where('active', '1')->first()->id],
            ['service_region_id', $this->attributes['serreg_id']], 
        ])
        ->whereYear('form_ppmps.created_at', $this->attributes['year'])
        ->whereMonth('form_ppmps.created_at', ">=", $semester_dates[$this->attributes['semester']]['start'])
        ->whereMonth('form_ppmps.created_at', "<=", $semester_dates[$this->attributes['semester']]['end'])
        ->pluck('budget')->first();



        return $formPpmp;
        // return FormPpmp::where([
        //     ['status_id','2'], 
        //     ['service_region_id', $this->attributes['serreg_id']], 
        //     ['stage_id', Stage::where('active', 1)->first()->id],
        // ])
        // ->whereYear('created_at', $this->attributes['year'])
        // ->whereMonth('created_at', ">=", $semester_dates[$this->attributes['semester']]['start'])
        // ->whereMonth('created_at', "<=", $semester_dates[$this->attributes['semester']]['end'])
        // ->get()
    }
    public function getFormattedCreatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }
    public function getFormattedUpdatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['updated_at'])->format('M j, Y h:i a');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('opc')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => ucwords("OPC/OPS")." {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
    public function returnable()
    {
        return $this->morphOne(ReturnedForm::class, 'returnable');
    }
    public function getOpcCodeAttribute()
    {
        if(@$this->attributes['id']){
            return "OPC-".str_pad($this->attributes['id'], 5, '0', STR_PAD_LEFT);
        }
    }
}
