<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ResourceAccount;
class ResourceAccess extends Model
{   
    protected $fillable = [
        "resource_id",
        "access_id",
    ];
    use HasFactory;
    public function access()
    {
        return $this->hasOne(ResourceAccount::class, "id", "access_id" );
    }
}
