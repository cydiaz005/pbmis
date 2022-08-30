<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class ContentHeader extends Component
{
    public $breadcrumb;
    public $pageTitle;
    public function render()
    {
        return view('livewire.partials.content-header');
    }


}
