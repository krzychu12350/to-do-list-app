<?php

namespace App\Contracts;

use App\Models\Task;

interface TaskTokenServiceInterface
{
    /**
     * Generate a public share token for the given task.
     *
     * @param Task $task
     * @param string|null $expiresAt
     * @return array
     */
    public function generateTaskToken(Task $task, ?string $expiresAt = null): array;
}
