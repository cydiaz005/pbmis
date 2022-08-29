<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormApp extends Model
{
    use HasFactory;

    protected $fillable = [
        "status_id",
        "stage_id",
        "year",
    ];
    protected $appends=["formatted_created_at", "formatted_updated_at"];
    public function getFormattedCreatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }
    public function getFormattedUpdatedAtAttribute()
    {
        return @\Carbon\Carbon::parse(@$this->attributes['created_at'])->format('M j, Y h:i a');
    }

    public function rows()
    {
        return $this->hasMany(FormAppRow::class, 'app_id', 'id');
    }
}
