<?php

namespace App\Jobs;

use App\Models\BlogPost;
use Carbon\Carbon;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use OpenAI\Laravel\Facades\OpenAI;

class RequestBlogPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $result = '';
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Generate an article about a feature of laravel. Provide your answer in markdown form. Reply with only the answer in markdown form. Add Extra Line breaks between paragraphs. Use code examples in markdown when needed.'],
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

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [(new ThrottlesExceptions(5, 5))->backoff(1)];
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): DateTime
    {
        return now()->addMinutes(5);
    }

    private function parseSubject($result): string
    {
        if (preg_match('/#(.*?)\\n/', $result, $match) == 1) {
            return $match[1];
        }

        return '';
    }
}
