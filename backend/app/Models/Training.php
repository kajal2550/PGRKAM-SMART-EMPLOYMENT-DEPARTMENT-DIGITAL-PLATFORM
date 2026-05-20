<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'provider', 'category', 'duration', 'total_seats',
        'enrolled_count', 'fee', 'description', 'syllabus',
        'certificate_type', 'start_date', 'end_date', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'syllabus'   => 'array',
            'start_date' => 'date',
            'end_date'   => 'date',
            'is_active'  => 'boolean',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'training_user')
                    ->withPivot('status', 'enrolled_at');
    }

    // ── Computed ──────────────────────────────────────────────────────────────

    public function getAvailableSeatsAttribute(): int
    {
        return max(0, $this->total_seats - $this->enrolled_count);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->enrolled_count >= $this->total_seats;
    }
}
