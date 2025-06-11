<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskViewController extends Controller
{
    public function index(Request $request)
    {

        return view('tasks.index');
    }

    public function showShareForm(Task $task)
    {
        return view('tasks.share');
    }
}
