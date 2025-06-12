<?php

namespace App\Http\Controllers;


class TaskViewController extends Controller
{
    public function index()
    {
        return view('tasks.index');
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function edit()
    {
        return view('tasks.edit');
    }

    public function show()
    {
        return view('tasks.show');
    }

    public function showShareForm()
    {
        return view('tasks.share');
    }

    public function showTaskHistory()
    {
        return view('tasks.history');
    }
}
