@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-bold mb-4">Create Task</h2>

        <form method="POST" action="{{ route('api.tasks.store') }}" id="task-form">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" />
                <p class="text-red-600 text-sm mt-1" id="error-name"></p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea name="description" id="description" class="w-full border rounded px-3 py-2"></textarea>
                <p class="text-red-600 text-sm mt-1" id="error-description"></p>
            </div>

            <!-- Priority -->
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium">Priority</label>
                <select name="priority" id="priority" class="w-full border rounded px-3 py-2">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <p class="text-red-600 text-sm mt-1" id="error-priority"></p>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium">Status</label>
                <select name="status" id="status" class="w-full border rounded px-3 py-2">
                    <option value="to-do">To-Do</option>
                    <option value="in progress">In Progress</option>
                    <option value="done">Done</option>
                </select>
                <p class="text-red-600 text-sm mt-1" id="error-status"></p>
            </div>

            <!-- Due Date -->
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="w-full border rounded px-3 py-2" />
                <p class="text-red-600 text-sm mt-1" id="error-due_date"></p>
            </div>

            <!-- Sync with Google Calendar -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="sync_with_google_calendar" id="sync_with_google_calendar"
                           class="form-checkbox text-blue-600" />
                    <span class="ml-2 text-sm">Sync with Google Calendar</span>
                </label>
                <p class="text-red-600 text-sm mt-1" id="error-sync_with_google_calendar"></p>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Task</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelector('#task-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const url = form.action;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const bearerToken = localStorage.getItem('auth_token');

            const data = {
                name: form.name.value.trim(),
                description: form.description.value.trim(),
                priority: form.priority.value,
                status: form.status.value,
                due_date: form.due_date.value,
                sync_with_google_calendar: form.sync_with_google_calendar.checked ? "1" : "0"
            };

            ['name', 'description', 'priority', 'status', 'due_date'].forEach(field => {
                const errorEl = document.getElementById(`error-${field}`);
                if (errorEl) errorEl.textContent = '';
            });

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Authorization': 'Bearer ' + bearerToken,
                    },
                    body: JSON.stringify(data),
                });

                const resData = await res.json();

                if (!res.ok) {
                    if (resData.errors) {
                        Object.entries(resData.errors).forEach(([field, messages]) => {
                            const errorEl = document.getElementById(`error-${field}`);
                            if (errorEl) errorEl.textContent = messages[0];
                        });
                    } else {
                        alert('Error: ' + (resData.message || 'Validation failed'));
                    }
                    return;
                }

                alert('Task created successfully!');
                window.location.href = '{{ route("tasks.index") }}';
            } catch (error) {
                alert('Unexpected error: ' + error.message);
            }
        });
    </script>
@endsection
