<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaskToken;

class TaskPublicController extends Controller
{
    /**
     * Display the task via public token in Blade view.
     */
    public function view(string $token)
    {
        $taskToken = TaskToken::where('token', $token)->first();

        if (!$taskToken || $taskToken->isExpired()) {
            abort(403, 'This link has expired or is invalid.');
        }

        return view('tasks.public', [
            'task' => $taskToken->task
        ]);
    }
}
