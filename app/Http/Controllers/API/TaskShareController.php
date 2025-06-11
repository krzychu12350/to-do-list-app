<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskToken;
use Illuminate\Support\Str;
use App\Http\Requests\GenerateTaskShareLinkRequest;

class TaskShareController extends Controller
{
    /**
     * Generate a public link for a task.
     */
    public function generateLink(GenerateTaskShareLinkRequest $request, Task $task)
    {
        // Optional: Ensure the task belongs to the authenticated user
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $token = Str::random(40);
        $expiresAt = $request->input('expires_at');

        $taskToken = TaskToken::create([
            'task_id'    => $task->id,
            'token'      => $token,
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'message'     => 'Public link generated successfully.',
            'public_link' => route('tasks.public.view', ['token' => $token]),
            'expires_at'  => $expiresAt,
        ]);
    }
}
