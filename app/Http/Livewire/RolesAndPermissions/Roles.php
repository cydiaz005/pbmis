<?php

namespace App\Http\Livewire\RolesAndPermissions;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Roles extends Component
{
    public $roleList;
    public function render()
    {
        return view('livewire.roles-and-permissions.roles');
    }

    public function mount()
    {
        $this->roleList = Role::where('name','!=','Banned')->get();
        // $this->roleList = $this->roleList[0]->permissions;
    }
}
