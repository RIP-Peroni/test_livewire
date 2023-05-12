<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;

class Comments extends Component
{
    public $comments = [
        [
            'body' => 'lorem ipsum dolor sit amet consectetur, adipisicing elit. Quasi ex cupditatte quo commodi aspernatur delectus veniam necessitatibus.',
            'created_at' => '3 min ago',
            'creator' => 'Yuriy',
        ]
    ];

    public $newComment;

    public function addComment()
    {
        array_unshift($this->comments, 
            [
                'body' => $this->newComment,
                'created_at' => Carbon::now()->diffForHumans(),
                'creator' => 'Smb else',
            ]
        );
        $this->newComment = '';
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
