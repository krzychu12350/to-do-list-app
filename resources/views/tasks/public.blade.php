@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6">Task Details (Shared)</h2>

        <div class="border rounded p-4 space-y-4">
            <div>
                <h3 class="text-xl font-semibold">{{ $task->name }}</h3>
                <p class="text-gray-700">{{ $task->description ?? 'No description provided.' }}</p>
            </div>

            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>Priority:</strong> <span class="capitalize">{{ $task->priority }}</span></p>
                <p><strong>Status:</strong> <span class="capitalize">{{ $task->status }}</span></p>
                <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
            </div>
        </div>
    </div>
@endsection
