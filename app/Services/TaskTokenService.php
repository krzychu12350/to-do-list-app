<?php

namespace App\Services;

use App\Contracts\TaskTokenServiceInterface;
use App\Models\Task;
use App\Models\TaskToken;

use Illuminate\Support\Str;

class TaskTokenService implements TaskTokenServiceInterface
{
    public function generateTaskToken(Task $task, ?string $expiresAt = null): array
    {
        $token = Str::random(40);

        $taskToken = TaskToken::create([
            'task_id'    => $task->id,
            'token'      => $token,
            'expires_at' => $expiresAt,
        ]);

        return [
            'token'      => $token,
            'expires_at' => $expiresAt,
            'public_link'=> route('tasks.public.view', ['token' => $token]),
        ];
    }
}
