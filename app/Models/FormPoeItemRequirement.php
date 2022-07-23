<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use DB;
use Illuminate\Support\Facades\Auth;

class FormPoeItemRequirement extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable=[
        "account_id",
        "itemreq_txt",
        "no_of_days",
        "per_capita_cost",
        "procurement_mode_id",
        "qty_pax",
        "subpap_id",
        "suggested_itemreq_id",
        "total",
        "unit",
        "unit_id",
    ];

    protected $appends = ['total'];



    public function itemMonths()
    {
        return $this->hasMany(FormPoeItemRequirementMonth::class, 'item_req_id', 'id')->orderBy('month');
    }
    public function itemMonthSum()
    {
        return $this->itemMonths()->groupBy('item_req_id')->select('id','item_req_id', DB::raw('sum(amount) as sum'));
    }

    public function itemQuarterGroup()
    {
        return $this->itemMonths()->groupBy('month')->orderBy('month', 'asc')->select('id','item_req_id', DB::raw('sum(month) as months'));
    }
    public function chartOfAccount()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id','account_id');
    }
    public function suggestedItemRequirement()
    {
        return $this->hasOne(ListOfItemRequirement::class, 'id', 'suggested_itemreq_id');
    }
    public function procurementMode()
    {
        return $this->hasOne(ProcurementMode::class, 'id', 'procurement_mode_id');
    }
    public function suggestedUnit()
    {
        return $this->hasOne(Units::class, 'id', 'unit_id');
    }
    public function appForm()
    {
        return $this->hasOne(FormAppRow::class, 'item_req_id', 'id');
    }
    public function getTotalAttribute()
    {
        return number_format(($this->attributes['per_capita_cost'] * $this->attributes['qty_pax'] * $this->attributes['no_of_days']), 2, '.', ',');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            -> useLogName('form_poe_item_requirement')
            -> logAll()
            -> setDescriptionForEvent(fn(string $eventName) => "POE Item Requirement {$eventName}.")
            -> logOnlyDirty()
            -> dontSubmitEmptyLogs();
    }
}
