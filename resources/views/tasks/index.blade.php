@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6">Your Tasks</h2>

        <!-- Filters -->
        <div class="mb-6 flex space-x-4">
            <select id="filterPriority" class="border rounded px-3 py-1">
                <option value="">All Priorities</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>

            <select id="filterStatus" class="border rounded px-3 py-1">
                <option value="">All Statuses</option>
                <option value="to-do">To-Do</option>
                <option value="in progress">In Progress</option>
                <option value="done">Done</option>
            </select>

            <input type="date" id="filterDueDate" class="border rounded px-3 py-1" placeholder="Due Date" />

            <button id="filterBtn" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">Filter</button>
            <button id="clearFilterBtn" class="bg-gray-300 px-4 py-1 rounded hover:bg-gray-400">Clear</button>
        </div>

        <div class="mb-4">
            <a href="{{ route('tasks.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Create Task</a>
        </div>

        <!-- Tasks -->
        <div id="tasksList" class="space-y-4"></div>
    </div>
@endsection

@section('scripts')
    <script>
        const apiBase = '{{ url("api") }}';
        const authToken = localStorage.getItem('auth_token');
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + authToken,
        };

        const tasksList = document.getElementById('tasksList');

        async function loadTasks() {
            let url = new URL(apiBase + '/tasks');

            const p = document.getElementById('filterPriority').value;
            const s = document.getElementById('filterStatus').value;
            const d = document.getElementById('filterDueDate').value;

            if (p) url.searchParams.append('priority', p);
            if (s) url.searchParams.append('status', s);
            if (d) url.searchParams.append('due_date', d);

            const res = await fetch(url, { headers });
            const data = await res.json();

            renderTasks(data.data || []);
        }

        function renderTasks(tasks) {
            tasksList.innerHTML = '';
            if (tasks.length === 0) {
                tasksList.innerHTML = `<p class="text-gray-500">No tasks found.</p>`;
                return;
            }

            tasks.forEach(task => {
                const div = document.createElement('div');
                div.className = "border rounded p-4 flex justify-between items-center";
                div.innerHTML = `
            <div>
                <h4 class="font-semibold text-lg">${task.name}</h4>
                <p class="text-sm text-gray-600">${task.description || ''}</p>
                <p class="text-xs text-gray-500 mt-1">
                    Priority: <span class="capitalize">${task.priority}</span> |
                    Status: <span class="capitalize">${task.status}</span> |
                    Due: ${task.due_date}
                </p>
            </div>
            <div class="space-x-2">
                <a href="/tasks/${task.id}" class="bg-blue-500 px-3 py-1 rounded text-white hover:bg-blue-600">View</a>
                <a href="/tasks/${task.id}/edit" class="bg-yellow-400 px-3 py-1 rounded text-white hover:bg-yellow-500">Edit</a>
                <button onclick="deleteTask(${task.id})" class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">Delete</button>
                <a href="/tasks/${task.id}/share" class="bg-purple-500 px-3 py-1 rounded text-white hover:bg-purple-600 inline-block text-center">Share</a>

            </div>
        `;
                tasksList.appendChild(div);
            });
        }


        async function deleteTask(id) {
            if (!confirm('Delete this task?')) return;

            const res = await fetch(apiBase + '/tasks/' + id, {
                method: 'DELETE',
                headers,
            });

            if (res.ok) loadTasks();
            else alert('Failed to delete task.');
        }

        document.getElementById('filterBtn').addEventListener('click', loadTasks);
        document.getElementById('clearFilterBtn').addEventListener('click', () => {
            document.getElementById('filterPriority').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterDueDate').value = '';
            loadTasks();
        });

        loadTasks();
    </script>
@endsection
