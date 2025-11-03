<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request('page', 1);
        $user = auth()->user();

        $cacheKey = 'posts.'.($user->id ?? 'guest').".page.{$page}";

        $posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user) {
            $query = Post::query()
                ->with(['user', 'media'])
                ->withCount(['claps', 'comments'])
                ->latest();

            if ($user) {
                $followingIds = $user->following()->pluck('users.id');
                $query->whereIn('user_id', $followingIds);
            }

            return $query->paginate(5);
        });

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('post.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('posts', 'public');
        //     $data['image'] = $imagePath;
        // }

        $post = Post::Create($data);

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')->toMediaCollection();
        }

        Cache::flush();

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Post $post)
    {
        return view('post.show', ['post' => $post, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    public function categories()
    {
        $categories = Category::all();
        $posts = Post::with(['user','media'])
        ->withCount(['claps','comments'])
        ->latest()
        ->paginate(5);

        return view('post.category', compact('categories', 'posts'));
    }

    public function category(Category $category)
    {
        $categories = Category::where('id')->get();
        $page = request('page', 1);

        $posts = Cache::remember("category.{$category->id}.page.{$page}", now()->addMinutes(10), function () use ($category) {
            return $category->posts()->latest()->paginate(5);
        });

        return view('post.category', compact('categories', 'posts', 'category'));
    }
}
