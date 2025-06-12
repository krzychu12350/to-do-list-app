<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskTokenPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }
}
