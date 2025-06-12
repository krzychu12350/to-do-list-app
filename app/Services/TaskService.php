<?php

namespace App\Services;

use App\Contracts\TaskServiceInterface;
use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private readonly GoogleCalendarService $calendarService
    ) {}

    public function list(Request $request): Collection|LengthAwarePaginator
    {
        $query = Task::where('user_id', Auth::id());

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('due_date')) {
            $query->whereDate('due_date', '<=', $request->due_date);
        }

        return $query->orderBy('due_date')->get();
    }

    public function create(array $data): Task
    {
        $task = Auth::user()->tasks()->create($data);

        if ($data['sync_with_google_calendar']) {
            $this->calendarService->createEventForTask($task);
        }

        return $task;
    }

    public function get(Task $task): Task
    {
        Gate::authorize('view', $task);
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        Gate::authorize('update', $task);

        // Check if there is any difference between original and new data
        $original = $task->getOriginal();

        $hasChanges = false;
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $original) && $original[$key] != $value) {
                $hasChanges = true;
                break;
            }
        }

        // Update the task first
        $task->update($data);

        // If at least one attribute changed, save the full snapshot
        if ($hasChanges) {
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'snapshot' => $task->toArray(),
            ]);
        }

        return $task;
    }

    public function delete(Task $task): void
    {
        Gate::authorize('delete', $task);
        $task->delete();
    }

    protected function authorize(Task $task): void
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
