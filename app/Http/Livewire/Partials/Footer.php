<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use Carbon\Carbon;
class Footer extends Component
{
    public $applictionName;
    public $copyrightYear;
    public $copyrightUrl;
    public $developer;


    public function render()
    {
        

        $default = env('APP_NAME', 'Telmo Solutions CMS');
        $this->applictionName = $default;
        $this->copyrightYear = env('APP_COPYRIGHT_YEAR', Carbon::now()->format('Y'));
        $this->copyrightUrl = env('APP_COPYRIGHT_URL', '#');
        $this->developer = env('APP_DEVELOPER', 'Telmo Solutions');


        return view('livewire.partials.footer');
    }
}
