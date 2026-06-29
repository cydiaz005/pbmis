<?php

namespace App\Http\Livewire\Partials;

use App\Models\FiscalLimit;
use App\Models\FormPoe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContentHeader extends Component
{
    public $breadcrumb;
    public $pageTitle;
    public $fiscal_limit;
    public $total_programmed_budget;
    public function render()
    {
        return view('livewire.partials.content-header');
    }

    public function mount()
    {
        $this->total_programmed_budget = FormPoe::totalProgrammedBudget(Auth::user()->serreg_id);
        $fiscal_limit = FiscalLimit::totalLimit(Auth::user()->serreg_id);
        $this->fiscal_limit = $fiscal_limit - $this->total_programmed_budget;
    }
}

