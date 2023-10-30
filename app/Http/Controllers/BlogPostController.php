<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class BlogPostController extends Controller
{
    public function index(Request $request)
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

    private function parseSubject($result): string
    {
        if (preg_match('/#(.*?)\\n/', $result, $match) == 1) {
            return $match[1];
        }

        return '';
    }
}
