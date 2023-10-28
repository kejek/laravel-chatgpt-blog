<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ShowPosts;
use Livewire\Livewire;
use Tests\TestCase;

class ShowPostsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ShowPosts::class)
            ->assertStatus(200);
    }
}
