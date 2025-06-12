@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6">Task Details</h2>

        <div class="border rounded p-4 space-y-4" id="task-details">
            <div>
                <h3 class="text-xl font-semibold" id="task-name">Loading...</h3>
                <p class="text-gray-700" id="task-description">Loading...</p>
            </div>

            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>Priority:</strong> <span class="capitalize" id="task-priority">-</span></p>
                <p><strong>Status:</strong> <span class="capitalize" id="task-status">-</span></p>
                <p><strong>Due Date:</strong> <span id="task-due-date">-</span></p>
            </div>

            <div class="flex space-x-4 mt-6">
                <a href="#" id="edit-link"
                   class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">
                    Edit
                </a>
                <a href="{{ route('tasks.index') }}"
                   class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Back to Tasks
                </a>
            </div>
        </div>
    </div>

    <script>
        const taskId = window.location.pathname.split('/').filter(Boolean).pop();

        document.addEventListener('DOMContentLoaded', async () => {
            if (!taskId) return console.error('No task ID provided.');

            try {
                const response = await fetch(`/api/tasks/${taskId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                    }
                });

                if (response.status === 403) {
                    document.getElementById('task-details').innerHTML =
                        `<p class="text-red-500">You are not authorized to view this task.</p>`;
                    return;
                }

                if (!response.ok) throw new Error('Failed to fetch task details');

                const { data } = await response.json();

                document.getElementById('task-name').textContent = data.name || 'Unnamed Task';
                document.getElementById('task-description').textContent = data.description || 'No description provided.';
                document.getElementById('task-priority').textContent = data.priority;
                document.getElementById('task-status').textContent = data.status;
                document.getElementById('task-due-date').textContent = formatDate(data.due_date);

                document.getElementById('edit-link').href = `/tasks/${data.id}/edit`;
            } catch (error) {
                document.getElementById('task-details').innerHTML = `<p class="text-red-500">Failed to load task.</p>`;
                console.error(error);
            }
        });

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth()+1).toString().padStart(2, '0')}-${date.getFullYear()}`;
        }
    </script>

@endsection
