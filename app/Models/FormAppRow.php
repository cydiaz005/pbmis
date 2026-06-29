<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAppRow extends Model
{
    use HasFactory;

    protected $fillable = [
        "app_procurement_program",
        "app_advertisement",
        "app_contract_signing",
        "app_notice_of_award",
        "app_remarks",
        "app_submission",
        "item_req_id",
        "app_id",
    ];
    protected $appends = ['formatted_dates'];
    public function getFormattedDatesAttribute()
    {
        return [
            "app_advertisement"=>Carbon::parse($this->attributes["app_advertisement"])->format("F Y"),
            "app_submission"=>Carbon::parse($this->attributes["app_submission"])->format("F Y"),
            "app_notice_of_award"=>Carbon::parse($this->attributes["app_notice_of_award"])->format("F Y"),
            "app_contract_signing"=>Carbon::parse($this->attributes["app_contract_signing"])->format("F Y"),
        ];
    }
}
