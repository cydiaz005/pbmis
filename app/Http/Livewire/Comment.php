<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

// use App\Models\Comment;

class Comment extends Component
{
    public $comments = [
        [
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nihil repudiandae! Ratione soluta earum quidem quo officia, eum aliquid error dicta, modi consequatur laboriosam sequi? Deserunt omnis inventore nihil. Tenetur.',
            'creator' => 'Blair Calhoun ',
            'created_at' => '15 mins',
        ]
    ];

    public $newComment;

    public function render()
    {
        return view('livewire.comment');
    }
    public function addNewComment()
    {
        // dd($this->newComment);
        array_unshift($this->comments, [
            'body' => $this->newComment,
            'creator' => 'Blair Calhoun ',
            'created_at' => Carbon::now()->diffForHumans(),
        ]);
        $this->newComment = "";
    }
}
