<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ShowPosts extends Component
{
    public function render(): View
    {
        return view('livewire.show-posts');
    }
}
