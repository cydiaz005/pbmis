<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $fillable = [
        "name",
        "guard_name",
        "model_id"
    ];

    use HasFactory;
    protected $table = 'roles';

  
}