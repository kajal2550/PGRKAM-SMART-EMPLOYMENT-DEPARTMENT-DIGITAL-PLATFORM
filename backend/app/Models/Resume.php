<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id', 'personal', 'education', 'experience',
        'skills', 'languages', 'score', 'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'personal'   => 'array',
            'education'  => 'array',
            'experience' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
