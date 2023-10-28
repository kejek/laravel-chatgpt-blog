<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class ShowPosts extends Component
{
    /** @var Collection<BlogPost> */
    public Collection $posts;

    public function render(): View
    {
        $this->posts = BlogPost::all();

        return view('livewire.show-posts');
    }
}
