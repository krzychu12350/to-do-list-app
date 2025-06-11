<form method="POST" action="{{ $url }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $task->name ?? '') }}"
               class="w-full border rounded px-3 py-2" />
        <p class="text-red-600 text-sm mt-1" id="error-name"></p>
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium">Description</label>
        <textarea name="description" id="description"
                  class="w-full border rounded px-3 py-2">{{ old('description', $task->description ?? '') }}</textarea>
        <p class="text-red-600 text-sm mt-1" id="error-description"></p>
    </div>

    <!-- Priority -->
    <div class="mb-4">
        <label for="priority" class="block text-sm font-medium">Priority</label>
        <select name="priority" id="priority" class="w-full border rounded px-3 py-2">
            <option value="low" {{ (old('priority', $task->priority ?? '') === 'low') ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ (old('priority', $task->priority ?? '') === 'medium') ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ (old('priority', $task->priority ?? '') === 'high') ? 'selected' : '' }}>High</option>
        </select>
        <p class="text-red-600 text-sm mt-1" id="error-priority"></p>
    </div>

    <!-- Status -->
    <div class="mb-4">
        <label for="status" class="block text-sm font-medium">Status</label>
        <select name="status" id="status" class="w-full border rounded px-3 py-2">
            <option value="to-do" {{ (old('status', $task->status ?? '') === 'to-do') ? 'selected' : '' }}>To-Do</option>
            <option value="in progress" {{ (old('status', $task->status ?? '') === 'in progress') ? 'selected' : '' }}>In Progress</option>
            <option value="done" {{ (old('status', $task->status ?? '') === 'done') ? 'selected' : '' }}>Done</option>
        </select>
        <p class="text-red-600 text-sm mt-1" id="error-status"></p>
    </div>

    <!-- Due Date -->
    <div class="mb-4">
        <label for="due_date" class="block text-sm font-medium">Due Date</label>
        <input type="date" name="due_date" id="due_date"
               value="{{ old('due_date', isset($task->due_date) ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
               class="w-full border rounded px-3 py-2" />
        <p class="text-red-600 text-sm mt-1" id="error-due_date"></p>
    </div>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Task</button>
</form>
