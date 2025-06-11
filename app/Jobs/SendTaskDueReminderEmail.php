<?php

namespace App\Jobs;

use App\Mail\TaskDueSoonNotification;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class SendTaskDueReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Carbon $dueDate;

    /**
     * Create a new job instance.
     */
    public function __construct(Carbon $dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasksDueTomorrow = Task::with('user')
            ->whereDate('due_date', '=', $this->dueDate)
            ->get()
            ->groupBy('user_id');


        foreach ($tasksDueTomorrow as $userId => $tasks) {
            $user = User::find($userId);

            Mail::to($user->email)->send(new TaskDueSoonNotification($user, $tasks, $this->dueDate));
        }

    }
}
