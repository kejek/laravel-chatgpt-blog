<?php

namespace App\Http\Controllers;

use App\Jobs\RequestBlogPost;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateBlogPostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $ip = $request->server('REMOTE_ADDR');

        if ($ip === '127.0.0.1') {
            return response()->json([
                'message' => 'Your ip is local? -  '.$ip,
            ]);
        } else {
            return response()->json([
                'message' => 'Your ip is not local - '.$ip,
            ]);
        }
        try {
            RequestBlogPost::dispatch();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}
