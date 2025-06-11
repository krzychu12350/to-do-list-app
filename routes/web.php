<?php

use App\Models\Task;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskViewController;

Route::get('/', function () {
    return view('welcome');
});

// Guest Views for Auth
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});



Route::get('test', function (){
   dd(auth()->user());
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

    Route::view('/tasks', 'tasks.index')->name('tasks.index');
    Route::view('/tasks/create', 'tasks.create')->name('tasks.create');

    Route::get('/tasks/{task}/edit', function (\App\Models\Task $task) {
        return view('tasks.edit', compact('task'));
    })->name('tasks.edit');

    // Add show route here:
    Route::get('/tasks/{task}', function (\App\Models\Task $task) {
        return view('tasks.show', compact('task'));
    })->name('tasks.show');

//Route::middleware('auth')->group(function () {
//    Route::view('/tasks', 'tasks.index')->name('tasks.index');
//    Route::view('/tasks/create', 'tasks.create')->name('tasks.create');
//
//    Route::get('/tasks/{task}/edit', function (\App\Models\Task $task) {
//        return view('tasks.edit', compact('task'));
//    })->name('tasks.edit');
//
//    // Add show route here:
//    Route::get('/tasks/{task}', function (\App\Models\Task $task) {
//        return view('tasks.show', compact('task'));
//    })->name('tasks.show');
//});


// Authenticated Views
Route::middleware('auth.token')->group(function () {



    // Optional logout form (for Blade logout via POST)
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');

});