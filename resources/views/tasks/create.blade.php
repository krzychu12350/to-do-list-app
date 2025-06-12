@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-bold mb-4">Create Task</h2>
        @include('tasks.partials.form', [
            'method' => 'POST',
            'url' => route('api.tasks.store'),
            'task' => null,
        ])
    </div>
@endsection
@section('scripts')
    <script>
        document.querySelector('form').addEventListener('submit', async function(e) {
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
                sync_with_google_calendar: form.sync_with_google_calendar?.checked ? "1" : "0"
            };

            // Clear previous error messages
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
