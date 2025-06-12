<?php

namespace App\Http\Controllers\API;

use App\Contracts\TaskHistoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TaskHistoryController extends Controller
{
    public function __construct(
        private readonly TaskHistoryServiceInterface $taskHistoryService
    ) {}

    /**
     * Display task histories.
     */
    public function index(Task $task): JsonResponse
    {
        Gate::authorize('view', $task);

        $histories = $this->taskHistoryService->getHistoriesForTask($task);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task histories fetched successfully.',
            'data'    => $histories,
        ]);
    }
}
