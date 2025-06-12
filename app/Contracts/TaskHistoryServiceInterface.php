<?php

namespace App\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskHistoryServiceInterface
{
    /**
     * Fetch task histories with users ordered by latest.
     *
     * @param Task $task
     * @return Collection
     */
    public function getHistoriesForTask(Task $task): Collection;
}
