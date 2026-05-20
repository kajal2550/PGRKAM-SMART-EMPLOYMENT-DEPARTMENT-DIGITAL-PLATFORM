<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings';

    protected $fillable = [
        'title', 'department', 'location', 'type', 'salary_range',
        'description', 'qualifications', 'vacancies', 'application_deadline',
        'posted_on', 'apply_url', 'is_active', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'qualifications'        => 'array',
            'application_deadline'  => 'date',
            'posted_on'             => 'date',
            'is_active'             => 'boolean',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs');
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeGovernment($query)
    {
        return $query->where('type', 'government');
    }

    public function scopePrivate($query)
    {
        return $query->where('type', 'private');
    }
}
