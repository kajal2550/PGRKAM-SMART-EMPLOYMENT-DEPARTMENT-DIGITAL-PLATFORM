<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass-assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'district',
        'qualification',
        'skills',
        'dob',
        'gender',
        'address',
        'profile_photo',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden in serialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function counsellingRequests()
    {
        return $this->hasMany(CounsellingRequest::class);
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs', 'user_id', 'job_id');
    }

    public function enrolledTrainings()
    {
        return $this->belongsToMany(Training::class, 'training_user')
                    ->withPivot('status', 'enrolled_at');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
