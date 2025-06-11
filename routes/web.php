<?php


use App\Http\Controllers\TaskPublicController;
use App\Mail\TaskDueSoonNotification;
use App\Models\Task;
use App\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskViewController;

Route::get('/', function () {
    return view('welcome');
});

// Guest Views for Auth
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::get('/tasks/public/{token}', [TaskPublicController::class, 'view'])
        ->name('tasks.public.view');
});

// Authenticated Views
Route::middleware('auth.token')->group(function () {

    // Optional logout form (for Blade logout via POST)
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::view('/tasks', 'tasks.index')->name('tasks.index');
    Route::view('/tasks/create', 'tasks.create')->name('tasks.create');

    //don't pass task into view
    Route::get('/tasks/{task}/edit', function (\App\Models\Task $task) {
        return view('tasks.edit', compact('task'));
    })->name('tasks.edit');

    //don't pass task into view
    Route::get('/tasks/{task}', function (\App\Models\Task $task) {
        return view('tasks.show', compact('task'));
    })->name('tasks.show');

    Route::get('/tasks/{task}/share', [TaskViewController::class, 'showShareForm'])->name('tasks.share.form');
    Route::get('/tasks/{task}/history', [TaskViewController::class, 'showTaskHistory'])->name('tasks.history');
});











Route::get('test', function () {
    dd(auth()->user());
});


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


Route::get('/test-email', function () {
//    $user = User::find(6);
//    if (!$user) {
//        return 'No users found.';
//    }
//
//    // For the test, pass dummy data as needed by your Mailable constructor
//    $tasks = $user->tasks; // empty collection or mock tasks
//    dd($tasks);

    $dueDate = Carbon::tomorrow(); // e.g. '2025-06-12'

    $tasksDueTomorrow = Task::with('user')
        ->whereDate('due_date', '=', $dueDate)
        ->get()
        ->groupBy('user_id');

   // dd($tasksDueTomorrow);

    foreach ($tasksDueTomorrow as $userId => $tasks) {
        $user = User::find($userId);
//        dd($user, $tasks, $dueDate);

       Mail::to($user->email)->send(new TaskDueSoonNotification($user, $tasks, $dueDate));
    }


    //Mail::to($user->email)->send(new TaskDueSoonNotification($user, $tasks, $dueDate));

    return 'Test email sent to ' . $user->email;
});
