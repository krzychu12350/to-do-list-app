<?php

namespace App\Services;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use App\Models\Task;

class GoogleCalendarService
{
    public function createEventForTask(Task $task): void
    {
        Event::create([
            'name' => $task->name,
            'description' => $task->description,
            'startDateTime' => Carbon::parse($task->due_date)->startOfDay(),
            'endDateTime' => Carbon::parse($task->due_date)->endOfDay(),
        ]);
    }
}
