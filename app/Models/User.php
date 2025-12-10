<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'email',
        'password',
        'phone', 
        'role',
        'is_admin',
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
            'is_admin' => 'boolean',
        ];
    }

    public function isFemale(): bool
    {
        
        return $this->gender === 'female'; 
        
       
    }

    /**
     * Accessor for `is_admin` that respects the `role` fallback.
     */
    public function getIsAdminAttribute(): bool
    {
        // Prefer the database column when present, otherwise treat role === 'admin' as admin
        if (array_key_exists('is_admin', $this->attributes)) {
            return (bool) $this->attributes['is_admin'];
        }

        return ($this->role === 'admin');
    }


}
