<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskViewController extends Controller
{
    public function index(Request $request)
    {

        return view('tasks.index');
    }
}
