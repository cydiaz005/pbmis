<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use Carbon\Carbon;
class FileCards extends Component
{
    public $params;
    public $icons;
    protected $listeners = ['newList'];


    public function render()
    {
        return view('livewire.partials.file-cards');
    }

    
    public function mount()
    {
        // $this->params = [
        //      "icon" => 'budget',
        //         "origin" => 'VIII',
        //         "title" => "Budget Form Funded 2022",
        //         "category" => "MOOE-CDE",
        //         "return_reason" => null,
        //         "date" =>  "2022-03-28 03:41:53",
        //         "amount" => "PHP 100,000",
        //         "last_editor" => "Gabriel Arellano",
        //         "updated_at" => "2022-03-28 03:41:53",
        //         'options' => [
        //             'view_url' => null,
        //             'edit_url' => null,
        //             'delete_url' => null,
        //             'publish_url' => null,
        //             'lock_enabled' => false,
        //             'resolve_enabled' => false,
        //             'download_enabled' => false,
        //         ],
        // ];

        $this->icons = [
            "poe" => "images/poeicon.png",
            "ppmp" => "images/ppmpicon.png",
            "opc" => "images/opcicon.png",
            "fiscal" => "images/fiscalicon.png",
            "budget" => "images/budgeticon.png",
        ];

    }

    public function timeShortHand($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
    public function readableDate($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
    public function fileIcon($key){

        return $this->icons[$key];
    }
}
