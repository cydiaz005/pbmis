<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use Carbon\Carbon;

class ShowComments extends Component
{
    public $comments = [];

    public $newComment;

    public function render()
    {
        return view('livewire.show-comments');
    }
    public function addNewComment()
    {
        $this->validate(['newComment' => 'required'],['newComment.required' => "Comment is required."]);
        Comment::create(['body' => $this->newComment,'user_id' => auth()->user()->id,]);
        $this->newComment = "";
        session()->flash('message', 'Comment successfully added.');
        sleep(3);
        $this->mount();
        
    }

    public function mount()
    {
        $this->comments = Comment::latest()->get();
    }
    
    public function updated($field)
    {
        // Hooks
        $this->validateOnly($field, ['newComment' => 'required'],['newComment.required' => "Comment is required."]);
    }
}
