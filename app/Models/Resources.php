<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResourceAccount;
use App\Models\ResourceAccess;
use DB;
use Auth;

class Resources extends Model
{
    protected $fillable = [
        "title",
        "description",
        "link",
        "status",
    ];
    protected $appends = ['resource_holder'];
    public function resourceAccount()
    {
        return $this->hasMany(ResourceAccess::class, "resource_id", "id");
    }
    public function getResourceHolderAttribute()
    {
        $role = Auth::user()->roles->first();       
        if( $role->id == 1){
          return  DB::table('resources')
            ->where("resources.id", $this->attributes['id'])
            ->join("resource_accesses", "resource_accesses.resource_id", "resources.id")
            ->join("resource_accounts", "resource_accounts.id", "resource_accesses.access_id")
            ->select(
                [
                    "resource_accounts.username as username", 
                    "resource_accounts.password as password",
                    "resource_accounts.role_id as role",
                    "resource_accounts.id as id",
                    "resource_accesses.id as access_id",
                ]
                )->get();
          
        }else{
           return DB::table('resources')
            ->where("resources.id", $this->attributes['id'])
            ->where("resource_accounts.role_id", $role->id)
            ->join("resource_accesses", "resource_accesses.resource_id", "resources.id")
            ->join("resource_accounts", "resource_accounts.id", "resource_accesses.access_id")
            
            ->select(
                [
                    "resource_accounts.username as username", 
                    "resource_accounts.password as password",
                    "resource_accounts.role_id as role",
                    "resource_accounts.id as id",
                    "resource_accesses.id as access_id",
                ]
                )->get();
        }
      
    }
  
    use HasFactory;
}
