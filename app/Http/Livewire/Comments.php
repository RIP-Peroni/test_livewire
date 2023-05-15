<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class Comments extends Component
{
    public $comments;

    public $newComment;

    protected $rules = [
        'newComment' => 'required|max:255',
    ];

    public function mount()
    {
        $initialComments = Comment::latest()->get();
        // dd($initialComments);
        $this->comments = $initialComments;
    }

    public function updated($newComment)
    {
        $this->validateOnly($newComment);
    }

    public function addComment()
    {
        $this->validate(($this->rules));
        $createdComment = Comment::create(['body' => $this->newComment, 'user_id' => 1]);
        $this->comments->prepend($createdComment);
        $this->newComment = '';
        session()->flash('comment added successfully', 'Comment added successfully 😀');
    }

    public function removeComment($commentId)
    {
        $commentToDestroy = Comment::find($commentId);
        $commentToDestroy->delete();
        
        $this->comments = $this->comments->except($commentId);
        
        session()->flash('comment removed successfully', 'Comment removed successfully 😔');
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
