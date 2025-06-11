<?php

namespace App\Console\Commands;

use App\Mail\TaskDueSoonNotification;
use Illuminate\Console\Command;
use App\Jobs\SendTaskDueReminderEmail;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendDueTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-due-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications for tasks due tomorrow';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $dueDate = Carbon::tomorrow()->startOfDay();

        SendTaskDueReminderEmail::dispatch($dueDate);

        $this->info('Dispatched SendTaskDueReminderEmail job for tasks due on ' . $dueDate->format('Y-m-d'));
    }
}
