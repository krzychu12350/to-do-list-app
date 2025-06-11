<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskHistory extends Model
{
    protected $fillable = ['task_id', 'user_id', 'snapshot'];

    protected $casts = [
        'snapshot' => 'array', // cast JSON to array automatically
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
