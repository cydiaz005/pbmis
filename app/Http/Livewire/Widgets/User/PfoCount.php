<?php

namespace App\Http\Livewire\Widgets\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
class PfoCount extends Component
{

    public $pfo_count;
    public function render()
    {
        return view('livewire.widgets.user.pfo-count');
    }

    public function mount()
    {
        $this->pfo_count = DB::table('model_has_roles')
        ->where('model_type', 'App\Models\User')
        ->where('role_id', 3)
        ->count();
    }
}
