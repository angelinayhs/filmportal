<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ExecutiveDashboardController;

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
// PREVENT GET LOGIN URLS
// =======================
Route::get('/marketing-login', fn () => redirect('/'));
Route::get('/executive-login', fn () => redirect('/'));

// =======================
// LOGIN MARKETING
// =======================
Route::post('/marketing-login', function (Request $request) {
    if ($request->email === 'mkt@studio.com' && $request->password === 'marketing123') {
        session(['role' => 'marketing']);
        return redirect()->route('marketing.dashboard'); // ✅ sekarang route-nya ada
    }
    return redirect('/')->with('login_error', 'Email atau password marketing salah.');
});

// =======================
// DASHBOARD MARKETING (named route ✅)
// =======================
Route::get('/marketing', [MarketingController::class, 'index'])
    ->name('marketing.dashboard');

// =======================
// LOGIN EXECUTIVE
// =======================
Route::post('/executive-login', function (Request $request) {
    if ($request->email === 'exec@studio.com' && $request->password === 'password123') {
        session(['role' => 'executive']);
        return redirect()->route('executive.dashboard'); // ✅ konsisten ke named route
    }
    return redirect('/')->with('login_error', 'Email atau password executive salah.');
});

// =======================
// EXECUTIVE DASHBOARD (pakai controller langsung ✅)
// =======================
Route::get('/executive', function () {
    // biar /executive tetap bisa dipakai sebagai shortcut
    return redirect()->route('executive.dashboard');
});

Route::get('/executive/dashboard', [ExecutiveDashboardController::class, 'index'])
    ->name('executive.dashboard');

// (opsional) CRUD executive kalau kamu memang pakai
Route::post('/executive/content', [ExecutiveDashboardController::class, 'create'])
    ->name('executive.content.create');

Route::put('/executive/content/{identifier}', [ExecutiveDashboardController::class, 'update'])
    ->name('executive.content.update');

Route::delete('/executive/content/{identifier}', [ExecutiveDashboardController::class, 'delete'])
    ->name('executive.content.delete');

Route::get('/executive/content/{identifier}', [ExecutiveDashboardController::class, 'show'])
    ->name('executive.content.show');

// Logout executive (biar gak dobel route)
Route::post('/executive/logout', function (Request $request) {
    $request->session()->forget('role');
    return redirect('/')->with('success', 'Logout berhasil.');
})->name('executive.logout');

// =======================
// LOGOUT GLOBAL
// =======================
Route::post('/logout', function () {
    session()->forget('role');
    return redirect('/');
});
