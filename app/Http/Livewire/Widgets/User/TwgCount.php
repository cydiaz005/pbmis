<?php

namespace App\Http\Livewire\Widgets\User;

use Livewire\Component;
use App\Models\User;

use Illuminate\Support\Facades\DB;
class TwgCount extends Component
{
    public $twg_count;

    public function render()
    {
        return view('livewire.widgets.user.twg-count');
    }

    public function mount()
    {
        $this->twg_count = DB::table('model_has_roles')
        ->where('model_type', 'App\Models\User')
        ->where('role_id', 4)
        ->count();
    }
}
