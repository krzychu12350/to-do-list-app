@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">
        <h2 id="taskTitle" class="text-xl font-bold mb-4">Historia zmian dla zadania...</h2>

        <div id="historyContainer">
            <p class="text-gray-600">Ładowanie historii zmian...</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const match = window.location.pathname.match(/\/tasks\/(\d+)\/history/);
            const taskId = match ? match[1] : null;

            const historyContainer = document.getElementById('historyContainer');
            const taskTitle = document.getElementById('taskTitle');
            const authToken = localStorage.getItem('auth_token');

            if (!taskId) {
                historyContainer.innerHTML = `<p class="text-red-600">Nieprawidłowy adres URL – brak ID zadania.</p>`;
                return;
            }

            async function loadTaskDetails() {
                try {
                    const res = await fetch(`/api/tasks/${taskId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + authToken
                        }
                    });

                    const result = await res.json();
                    if (!res.ok) throw new Error(result.message || 'Nie udało się załadować zadania.');

                    taskTitle.innerText = `Historia zmian dla zadania: ${result.data.name}`;
                } catch (e) {
                    taskTitle.innerText = 'Nie udało się załadować szczegółów zadania.';
                }
            }

            async function loadTaskHistory() {
                try {
                    const res = await fetch(`/api/tasks/${taskId}/history`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + authToken
                        }
                    });

                    const result = await res.json();

                    if (!res.ok) {
                        throw new Error(result.message || 'Błąd podczas ładowania historii.');
                    }

                    const histories = result.data;

                    if (histories.length === 0) {
                        historyContainer.innerHTML = `<p class="text-gray-600">Brak historii zmian.</p>`;
                        return;
                    }

                    let html = '<ul class="space-y-6">';
                    histories.forEach(h => {
                        const snap = h.snapshot;
                        html += `
                            <li class="border p-4 rounded shadow-sm bg-gray-50">
                                <p class="text-sm font-semibold mb-2">Zmiany z dnia: ${new Date(h.created_at).toLocaleString('pl-PL')}</p>
                                <ul class="text-sm space-y-1">
                                    <li><strong>Nazwa:</strong> ${snap.name || '-'}</li>
                                    <li><strong>Opis:</strong> ${snap.description || '-'}</li>
                                    <li><strong>Priorytet:</strong> ${snap.priority || '-'}</li>
                                    <li><strong>Status:</strong> ${snap.status || '-'}</li>
                                    <li><strong>Data wykonania:</strong> ${snap.due_date || '-'}</li>
                                </ul>
                                <p class="text-xs text-gray-500 mt-1">Zapisane przez: ${h.user?.name ?? 'System'}</p>
                            </li>
                        `;
                    });
                    html += '</ul>';

                    historyContainer.innerHTML = html;

                } catch (error) {
                    historyContainer.innerHTML = `<p class="text-red-600">Błąd: ${error.message}</p>`;
                }
            }

            await loadTaskDetails();
            await loadTaskHistory();
        });
    </script>
@endsection
