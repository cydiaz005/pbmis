<?php

namespace App\Http\Livewire\Mail;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class Compose extends Component
{
    public $name = "TEST";
    public $query = "";
    public $message = "";
    public $subject = "";
    public $description = "";
    public $results = [];
    public $receivers = [];
    public $receiverData = [];


    protected $queryString = ['query'];

    public function mount()
    {
        // $this->reset();
    }
    public function updatedQuery()
    {
        if(strlen($this->query) == 0){
            $this->results = [];
        }
        else{
            $this->results = User::select('id', 'name', 'email')
            ->where('name', 'like', '%'.$this->query.'%')
            ->orWhere('email', 'like', '%'.$this->query.'%')
            ->get();
        }
        
    }
    public function updatedReceiverData()
    {
        foreach ($this->receiverData as $receiver) {
            $this->receiverData[] = $receiver;
        }
    }
    
    public function render()
    {
        
            // $query = $this->query;
            // $except = [Auth::user()->id];
            // $this->results = User::select('id', 'name', 'email')
            // ->whereNotIn('id', $except)
            // ->where(function($q) use ($query) {
            //     $q->where('name', 'like', '%'.$query.'%');
            //     $q->orWhere('email', 'like', '%'.$query.'%');
            // })
            // ->take(5)
            // ->get();
            
            // dd($this->results);
               
            return view('livewire.mail.compose');
    }
    public function setSendToEmail($receiver){
        $receiver = json_decode($receiver);
        array_push($this->receiverData, $receiver);
        $this->query = "";
        // $this->results = [];
    }
}
