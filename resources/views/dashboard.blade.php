@extends('layouts.app')

@section('content')
    <div class="w-full max-w-4xl">
        <h1 class="text-xl font-semibold mb-6">Your Tasks</h1>

        <!-- Filter Menu -->
        <div class="mb-4 flex flex-wrap gap-4 items-center">
            <select class="input" name="priority">
                <option value="">All Priorities</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>

            <select class="input" name="status">
                <option value="">All Statuses</option>
                <option value="to-do">To-Do</option>
                <option value="in-progress">In Progress</option>
                <option value="done">Done</option>
            </select>

            <input type="date" name="due_date" class="input">
            <button class="btn">Filter</button>
        </div>

        <!-- Tasks Table -->
        <div class="overflow-x-auto rounded shadow bg-white dark:bg-[#161615]">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 dark:bg-[#1e1e1e]">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Priority</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Due</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                {{-- @foreach($tasks as $task)
                <tr class="border-t dark:border-[#3E3E3A]">
                    <td class="px-4 py-2">Example Task</td>
                    <td class="px-4 py-2">High</td>
                    <td class="px-4 py-2">To-Do</td>
                    <td class="px-4 py-2">2025-06-20</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
                 @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
