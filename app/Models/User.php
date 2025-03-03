<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable;
use MongoDB\Laravel\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $collection = 'users';

    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'fullname',
        'password',
        'email',
        'followers',
        'following',
        'profileImage',
        'coverImage',
        'bio',
        'link',
    ];

    protected $attributes = [
        'followers' => [],
        'following' => [],
        'profileImage' => '',
        'coverImage' => '',
        'bio' => '',
        'link' => '',
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

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follower', 'follower_id', 'user_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follower', 'user_id', 'follower_id');
    }
}
