<?php

namespace App\Http\Controllers;

use App\Models\Post;

class ClapController extends Controller
{
    public function clap(Post $post)
    {
        $hasClapped = $post->claps()
            ->where('user_id', auth()->user()->id)
            ->exists();

        if ($hasClapped) {
            $post->claps()->where('user_id', auth()->id())->delete();
        } else {
            $post->claps()->create(['user_id' => auth()->id(),
            ]);
        }

        return response()->json([
            'claps' => $post->claps()->count(),
        ]);
    }
}
