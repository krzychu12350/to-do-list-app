<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Task Reminder</title>
    <style>
        /* Minimal inline Tailwind-style CSS for email clients */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            padding: 20px;
            color: #111827;
        }
        .container {
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
        }
        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        h3 {
            font-size: 18px;
            font-weight: 500;
            margin-top: 20px;
            margin-bottom: 8px;
            color: #1f2937;
        }
        .task {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }
        .footer {
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Reminder: You have tasks due tomorrow!</h1>

    <p>Hello {{ $user->name }},</p>

    <p>This is a friendly reminder that you have the following tasks due on <strong>{{ $dueDate->format('Y-m-d') }}</strong>:</p>

    @foreach ($tasks as $task)
        <div class="task">
            <h3>{{ $task->name }}</h3>
            <p><strong>Description:</strong> {{ $task->description ?? 'No description' }}</p>
            <p><strong>Priority:</strong> {{ ucfirst($task->priority->value) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($task->status->value) }}</p>
            <a href="{{ url('/tasks/' . $task->id) }}" class="button">View Task</a>
        </div>
    @endforeach

    <div class="footer">
        Thanks,<br>
        {{ config('app.name') }}
    </div>
</div>
</body>
</html>
