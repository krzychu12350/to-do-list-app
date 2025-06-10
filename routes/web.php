<?php

use Illuminate\Support\Facades\Route;

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