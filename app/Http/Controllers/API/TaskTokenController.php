<?php

namespace App\Http\Controllers\API;

use App\Contracts\TaskTokenServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateTaskShareLinkRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TaskTokenController extends Controller
{
    public function __construct(
        private readonly TaskTokenServiceInterface $taskTokenService
    ) {}

    public function generateLink(GenerateTaskShareLinkRequest $request, Task $task): JsonResponse
    {
        Gate::authorize('view', $task);

        $tokenData = $this->taskTokenService->generateTaskToken(
            $task,
            $request->input('expires_at')
        );

        return $this->successResponse([
            'public_link' => $tokenData['public_link'],
            'expires_at'  => $tokenData['expires_at'],
        ], 'Public link generated successfully.');
    }
}
