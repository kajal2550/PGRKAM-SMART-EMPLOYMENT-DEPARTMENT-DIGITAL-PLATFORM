<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounsellingRequest extends Model
{
    protected $fillable = [
        'user_id', 'counsellor_name', 'preferred_date', 'time_slot',
        'topic', 'notes', 'status', 'counsellor_feedback',
    ];

    protected function casts(): array
    {
        return ['preferred_date' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
