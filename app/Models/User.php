<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function imageUrl(): string
    {
        return $this->image
            ? Storage::url($this->image)
            : 'https://api.dicebear.com/8.x/micah/svg?seed='.urlencode($this->id);
    }
}
