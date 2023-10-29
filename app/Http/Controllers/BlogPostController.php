<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Carbon\Carbon;
use OpenAI\Laravel\Facades\OpenAI;

class BlogPostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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
}
