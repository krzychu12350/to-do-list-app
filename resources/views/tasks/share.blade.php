@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6">
            Share Task: <span id="taskName">Loading...</span>
        </h2>

        <form id="shareForm" class="space-y-4">
            @csrf
            <div>
                <label for="expires_at" class="block font-medium mb-1">Expiration Date & Time</label>
                <input
                        type="datetime-local"
                        id="expires_at"
                        name="expires_at"
                        class="border rounded w-full px-3 py-2"
                        required
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}"
                />
                <p class="text-sm text-gray-600 mt-1">Set when the public link will expire.</p>
            </div>

            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Generate Shareable Link
            </button>
        </form>

        <div id="result" class="mt-6 hidden p-4 bg-green-100 border border-green-400 rounded">
            <p class="font-semibold mb-2">Public Link Generated and Copied to Clipboard:</p>
            <a href="#" target="_blank" id="publicLink" class="text-blue-600 underline break-all"></a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Extract task ID from URL using RegExp
        const match = window.location.pathname.match(/\/tasks\/(\d+)\/share/);
        const taskId = match ? match[1] : null;

        const taskNameSpan = document.getElementById('taskName');

        if (!taskId) {
            taskNameSpan.textContent = 'Invalid task URL';
            throw new Error('Task ID not found in URL.');
        }

        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch(`/api/tasks/${taskId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                    }
                });
                if (!response.ok) throw new Error('Failed to fetch task details');
                const data = await response.json();

                taskNameSpan.textContent = data.data.name || 'Unnamed Task';
            } catch (error) {
                taskNameSpan.textContent = 'Error loading task';
                console.error(error);
            }
        });

        document.getElementById('shareForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;
            button.textContent = 'Generating...';

            const expiresAt = document.getElementById('expires_at').value;

            try {
                const response = await fetch(`/api/tasks/${taskId}/share`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ expires_at: expiresAt })
                });

                if (!response.ok) throw new Error('Failed to generate public link');

                const data = await response.json();
                const link = data.public_link;

                await navigator.clipboard.writeText(link);

                const resultDiv = document.getElementById('result');
                const publicLinkAnchor = document.getElementById('publicLink');
                publicLinkAnchor.href = link;
                publicLinkAnchor.textContent = link;
                resultDiv.classList.remove('hidden');

                button.textContent = 'Generate Shareable Link';
                button.disabled = false;
            } catch (error) {
                alert('Error: ' + error.message);
                button.textContent = 'Generate Shareable Link';
                button.disabled = false;
            }
        });
    </script>
@endsection
