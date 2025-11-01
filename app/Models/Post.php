<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claps(){

        return $this->hasMany(Clap::class);
    }

    

    // Accessors
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function imageUrl(): string
    {
        // 1. Check if the image property is already a full URL
        //    (e.g., from picsum, dicebear, or robohash)
        if (Str::startsWith($this->image, 'http')) {
            return $this->image;
        }

        // 2. If the image is empty or null, return a default avatar
        if (empty($this->image)) {
            // You can use any default you want here
            return 'https://api.dicebear.com/8.x/adventurer/svg?seed='.$this->id;
        }

        // 3. If it's not a full URL and not empty,
        //    it must be a local file. Get the URL from Storage.
        return Storage::url($this->image);
    }

    public function readTime($wordsPerMinute = 100): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordsPerMinute);

        return max(1, $minutes);
    }

    // Using booted method to auto-set slug and user_id
    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
            $post->user_id = auth()->id();
        });
    }
}
