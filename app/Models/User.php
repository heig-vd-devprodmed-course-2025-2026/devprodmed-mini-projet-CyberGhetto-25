<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Event;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $hidden = ['password', 'remember_token'];
    
    /**
     * Get the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    /**
    * Get the posts liked by the user.
    */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes')->using(Like::class)->withTimestamps()->withPivot('reaction');
    }

    /**
    * Get the events organized by the user.
    */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
    * Get the events the user is attending or interested in.
    */
    public function attendances(): BelongsToMany
    {
    return $this->belongsToMany(Event::class, 'event_user')
        ->withPivot('status')
        ->withTimestamps();
    }

    /**
    * Check if the user is an organizer.
    */
    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }
}
