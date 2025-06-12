<?php

namespace App\Contracts;

use App\Models\Task;

interface GoogleCalendarServiceInterface
{
    public function createEventForTask(Task $task): void;
}
