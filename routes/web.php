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
    if (
        $request->email === 'exec@studio.com' &&
        $request->password === 'password123'
    ) {
        session(['role' => 'executive']);
        return redirect()->route('executive.dashboard');
    }

    return redirect('/')->with('login_error', 'Email atau password executive salah.');
});

// ✅ FIX: Ganti 'dashboard' dengan 'index' atau sebaliknya
Route::get('/executive', [ExecutiveDashboardController::class, 'index'])
    ->name('executive.dashboard');

// Route untuk logout executive (jika ada method khusus)
Route::post('/executive/logout', [ExecutiveDashboardController::class, 'logout']);

// =======================
// LOGIN MARKETING
// =======================
Route::post('/marketing-login', function (Request $request) {
    if (
        $request->email === 'mkt@studio.com' &&
        $request->password === 'marketing123'
    ) {
        session(['role' => 'marketing']);
        return redirect()->route('marketing.dashboard');
    }

    return redirect('/')->with('login_error', 'Email atau password marketing salah.');
});

// ✅ FIX: Marketing route menggunakan controller langsung
Route::get('/marketing', [MarketingController::class, 'index'])
    ->name('marketing.dashboard');

// =======================
// LOGOUT
// =======================
Route::post('/logout', function () {
    session()->forget('role');
    return redirect('/');
});

// Biar kalau user buka /marketing-login lewat browser, ga nge-trigger apa2
Route::get('/marketing-login', function () {
    return redirect('/');
});

// Biar kalau user buka /executive-login lewat browser, ga nge-trigger apa2
Route::get('/executive-login', function () {
    return redirect('/');
});