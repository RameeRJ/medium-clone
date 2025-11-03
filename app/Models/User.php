<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, InteractsWithMedia ,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'image',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = ['avatar_url']; // Make it always available in JSON

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width(128)
            ->crop(128, 128);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    // Relations

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followingCount()
    {
        $count = $this->following()->count();

        if ($count >= 1000000) {
            return round($count / 1000000, 1).'M';
        } elseif ($count >= 1000) {
            return round($count / 1000, 1).'K';
        }

        return (string) $count;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followersCount()
    {
        $count = $this->followers()->count();

        if ($count >= 1000000) {
            return round($count / 1000000, 1).'M';
        } elseif ($count >= 1000) {
            return round($count / 1000, 1).'K';
        }

        return (string) $count;
    }

    public function isFollowedBy(User $user): bool
    {
        return $this->followers()
            ->where('follower_id', $user->id)
            ->exists();
    }

    public function hasClapped(Post $post): bool
    {
        return Clap::where('user_id', $this->id)
            ->where('post_id', $post->id)
            ->exists();
    }

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->imageUrl();
    }

    public function imageUrl($conversionName = '')
    {
        $media = $this->getFirstMedia('avatar');

        if ($media) {
            return $media->hasGeneratedConversion('avatar')
                ? $media->getUrl('avatar')
                : $media->getUrl();
        }

        return 'https://api.dicebear.com/8.x/micah/svg?seed='.urlencode($this->id);
    }
}
