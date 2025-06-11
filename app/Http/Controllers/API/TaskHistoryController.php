<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TaskHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Task $task): JsonResponse
    {
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $histories = $task->histories()->with('user')->orderByDesc('created_at')->get();

        return $this->successResponse($histories);
    }
}
