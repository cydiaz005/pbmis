<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPoeItemRequirementMonth extends Model
{
    protected $fillable = [
        "item_req_id",
        "amount",
        "month",
        "qty",
    ];

    protected $appends = ['quarter'];
    use HasFactory;

    public function getQuarterAttribute()
    {
        if (@$this->attributes["month"]) {
            $q = [[1, 2, 3], [4, 5, 6], [7, 8, 9], [10, 11, 12]];
            for ($i = 0; $i < count($q); $i++) {
                if (in_array($this->attributes["month"], $q[$i])) {
                    return $i + 1;
                }
            }
        }
    }
}
