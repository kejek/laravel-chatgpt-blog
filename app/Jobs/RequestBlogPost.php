<?php

namespace App\Jobs;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI\Laravel\Facades\OpenAI;

class RequestBlogPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var Collection $posts */
        $posts = BlogPost::pluck('subject')->all();

        ray($posts);

        $titles = '';

        foreach ($posts as $post) {
            ray($post);
            $titles = $titles.', '.$post;
        }

        $result = '';
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Generate an article about a feature of laravel. Provide your answer in markdown form. Reply with only the answer in markdown form. Add Extra Line breaks between paragraphs. Use code examples in markdown when needed. Do not repeat these articles: '.$titles],
            ],
        ]);

        $result = $result['choices'][0]['message']['content'];

        $post = new BlogPost();

        $subject = '';

        $subject = $this->parseSubject($result);

        $subject = str_replace(['#', '*'], '', $subject);

        $result = str_replace($subject, '', $result);

        $data = [
            'user_id' => 1,
            'subject' => $subject,
            'body' => $result,
            'created_at' => Carbon::now(),
        ];

        $post->fill($data);

        $post->save();
    }

    private function parseSubject($result): string
    {
        if (preg_match('/#(.*?)\\n/', $result, $match) == 1) {
            return $match[1];
        }

        return '';
    }
}
