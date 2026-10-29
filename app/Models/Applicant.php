<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class applicant extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'contact_phone',
        'contact_email',
        'message',
        'location',
        'resume_path',
    ];

    //relation to job
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    //relation to user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
