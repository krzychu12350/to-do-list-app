@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-bold mb-4">Edit Task</h2>

        <form method="POST" id="task-form">
            @csrf
            @method('PUT')

            <!-- Same form structure as in create.blade.php, but without the checkbox block -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" />
                <p class="text-red-600 text-sm mt-1" id="error-name"></p>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea name="description" id="description" class="w-full border rounded px-3 py-2"></textarea>
                <p class="text-red-600 text-sm mt-1" id="error-description"></p>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium">Priority</label>
                <select name="priority" id="priority" class="w-full border rounded px-3 py-2">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <p class="text-red-600 text-sm mt-1" id="error-priority"></p>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium">Status</label>
                <select name="status" id="status" class="w-full border rounded px-3 py-2">
                    <option value="to-do">To-Do</option>
                    <option value="in progress">In Progress</option>
                    <option value="done">Done</option>
                </select>
                <p class="text-red-600 text-sm mt-1" id="error-status"></p>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="w-full border rounded px-3 py-2" />
                <p class="text-red-600 text-sm mt-1" id="error-due_date"></p>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Task</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const match = window.location.pathname.match(/\/tasks\/(\d+)\/edit/);
        const taskId = match ? match[1] : null;
        const apiUrl = '{{ route("api.tasks.show", ":id") }}'.replace(':id', taskId);
        const updateUrl = '{{ route("api.tasks.update", ":id") }}'.replace(':id', taskId);
        const bearerToken = localStorage.getItem('auth_token');

        document.addEventListener('DOMContentLoaded', async () => {
            const form = document.getElementById('task-form');
            form.action = updateUrl;

            try {
                const res = await fetch(apiUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + bearerToken,
                    }
                });

                const json = await res.json();
                console.log('Fetched task data:', json);

                if (!res.ok) throw new Error(json.message || 'Failed to load task');

                const data = json.data || json;

                form.name.value = data.name || '';
                form.description.value = data.description || '';
                form.priority.value = data.priority || 'low';
                form.status.value = data.status || 'to-do';
                form.due_date.value = data.due_date ? data.due_date.slice(0, 10) : '';
            } catch (error) {
                alert('Error loading task: ' + error.message);
            }
        });


        document.querySelector('#task-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = {
                name: form.name.value.trim(),
                description: form.description.value.trim(),
                priority: form.priority.value,
                status: form.status.value,
                due_date: form.due_date.value,
            };

            ['name', 'description', 'priority', 'status', 'due_date'].forEach(field => {
                const errorEl = document.getElementById(`error-${field}`);
                if (errorEl) errorEl.textContent = '';
            });

            try {
                const res = await fetch(form.action, {
                    method: 'PUT',
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
                        alert('Error: ' + (resData.message || 'Failed to update task'));
                    }
                    return;
                }

                alert('Task updated successfully!');
                window.location.href = '{{ route("tasks.index") }}';
            } catch (error) {
                alert('Unexpected error: ' + error.message);
            }
        });
    </script>
@endsection
