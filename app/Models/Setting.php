<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable=[
        "key",
        "value",
    ];

    public function scopeChangingStage($query)
    {
        return $query->where([
            ["key","changing_stage"],
            ["value",1]
        ])->exists();
    }
}
