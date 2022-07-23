<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceAccount extends Model
{   
    protected $fillable = [
        "username",
        "password",
        "role_id"
    ];
    use HasFactory;
}
