<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ExecutiveDashboardController;
use App\Http\Controllers\ReportController;

// =======================
// HOME
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');

// =======================
// DETAIL SHOW
// =======================
Route::get('/film/{id}', [ShowController::class, 'detail'])->name('film.detail');

// =======================
// SEARCH SUGGESTIONS
// =======================
Route::get('/api/search-suggestions', [SearchController::class, 'suggestions']);

// =======================
// LOGIN EXECUTIVE
// =======================
Route::post('/executive-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'exec@studio.com' && $password === 'password123') {
        session(['role' => 'executive']);
        return redirect()->route('executive.dashboard');
    }

    return redirect('/')->with('login_error', 'Email atau password executive salah.');
});

// ✅ SATU AJA ROUTE EXECUTIVE (controller)
Route::get('/executive', [ExecutiveDashboardController::class, 'index'])
    ->name('executive.dashboard');

// =======================
// LOGIN MARKETING
// =======================
Route::post('/marketing-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'mkt@studio.com' && $password === 'marketing123') {
        session(['role' => 'marketing']);
        return redirect('/marketing');
    }

    return redirect('/')->with('login_error', 'Email atau password marketing salah.');
});

Route::get('/marketing', function () {
    if (session('role') !== 'marketing') {
        return redirect('/')->with('login_error', 'Kamu harus login sebagai Marketing dulu.');
    }
    return app(MarketingController::class)->index(request());
});

// =======================
// LOGOUT
// =======================
Route::post('/logout', function () {
    session()->forget('role');
    return redirect('/');
});
