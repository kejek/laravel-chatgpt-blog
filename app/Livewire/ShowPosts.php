<?php

namespace App\Livewire;

use App\Models\BlogPost;
use App\Services\CommonMark;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\ShikiPhp\Shiki;

class ShowPosts extends Component
{
    use WithPagination;

    public function render(): View
    {

        $response = Shiki::highlight(
            code: '<?php echo "Hello World"; ?>',
            language: 'php',
        );

        echo $response;

        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(2);

        $convertedCollection = new Collection();

        foreach ($posts->getCollection() as $post) {
            $post->body = CommonMark::convertToHtml($post->body);
            $convertedCollection->add($post);
        }

        $posts->setCollection($convertedCollection);

        return view('livewire.show-posts', [
            'posts' => $posts,
        ]);
    }
}
