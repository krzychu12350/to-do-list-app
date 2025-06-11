<?php

namespace App\Http\Controllers\API;

use App\Contracts\TaskServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskServiceInterface $taskService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskService->list($request);

        return $this->successResponse($tasks,  Response::HTTP_OK);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request->validated());

        return $this->successResponse($task, 'Task created', Response::HTTP_CREATED);
    }

    public function show(Task $task): JsonResponse
    {
        $task = $this->taskService->get($task);

        return $this->successResponse($task, Response::HTTP_OK);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $updated = $this->taskService->update($task, $request->validated());

        return $this->successResponse($updated, 'Task updated', Response::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->taskService->delete($task);

        return $this->successResponse([], 'Task deleted', Response::HTTP_NO_CONTENT);
    }
}
