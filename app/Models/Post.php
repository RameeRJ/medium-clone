<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        // 'image',
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400);
        $this
            ->addMediaConversion('large')
            ->width(1200);
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claps()
    {

        return $this->hasMany(Clap::class);
    }

    public function comments()
    {

        return $this->hasMany(Comment::class);
    }

    // Accessors
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function imageUrl($conversionName = '')
    {
        return $this->getFirstMedia()?->getUrl($conversionName);
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
