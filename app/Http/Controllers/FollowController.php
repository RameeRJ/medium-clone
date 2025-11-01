<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class FollowController extends Controller
{
    public function followUnfollow(User $user)
    {
        $user->followers()->toggle(auth()->user());

        Cache::flush();

        return response()->json([
            'followers' => $user->followersCount(),
        ]);

    }
}
