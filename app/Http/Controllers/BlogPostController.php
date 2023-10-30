<?php

namespace App\Http\Controllers;

use App\Jobs\RequestBlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        RequestBlogPost::dispatch();

        return response()->json([
            'message' => 'success',
        ]);
    }
}
