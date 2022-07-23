<?php

namespace App\Http\Livewire\Widgets\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
class AdminCount extends Component
{
    public $admin_count = 0;

    public function render()
    {
        return view('livewire.widgets.user.admin-count');
    }
    public function mount()
    {
        $this->admin_count = DB::table('model_has_roles')
        ->where('model_type', 'App\Models\User')
        ->where('role_id', 2)
        ->count();
    }
}
