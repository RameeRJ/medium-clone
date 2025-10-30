<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowController extends Controller
{
    public function followUnfollow(User $user)
    {
        $user->followers()->toggle(auth()->user());

        return response()->json([
            'followers' => $user->followersCount(),
        ]);

    }
}
