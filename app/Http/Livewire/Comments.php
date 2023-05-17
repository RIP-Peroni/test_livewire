<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $newComment;
    public $image;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    protected $rules = [
        'newComment' => 'required|max:255',
    ];

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function updated($newComment)
    {
        $this->validateOnly($newComment);
    }

    public function addComment()
    {
        $this->validate(($this->rules));
        $createdComment = Comment::create(['body' => $this->newComment, 'user_id' => 1]);
        $this->newComment = '';
        session()->flash('comment added successfully', 'Comment added successfully 😀');
    }

    public function removeComment($commentId)
    {
        $commentToDestroy = Comment::find($commentId);
        $commentToDestroy->delete();
        
        session()->flash('comment removed successfully', 'Comment removed successfully 😔');
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(5),
        ]);
    }
}
