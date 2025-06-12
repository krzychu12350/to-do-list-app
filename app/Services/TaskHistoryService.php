<?php

namespace App\Services;

use App\Contracts\TaskHistoryServiceInterface;
use App\Models\Task;

use Illuminate\Database\Eloquent\Collection;

class TaskHistoryService implements TaskHistoryServiceInterface
{
    public function getHistoriesForTask(Task $task): Collection
    {
        return $task->histories()->with('user')->orderByDesc('created_at')->get();
    }
}
