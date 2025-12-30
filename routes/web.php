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
        return redirect('/executive');
    }

    return redirect('/')->with('login_error', 'Email atau password executive salah.');
});

Route::get('/executive', function () {

    if (session('role') !== 'executive') {
        return redirect('/')->with('login_error', 'Kamu harus login sebagai Executive dulu.');
    }

    return app(\App\Http\Controllers\ExecutiveDashboardController::class)->index();
});

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

// =======================
// DASHBOARD MARKETING ✅ FIXED
// =======================
Route::get('/marketing', function (Request $request) {

    if (session('role') !== 'marketing') {
        return redirect('/')->with('login_error', 'Kamu harus login sebagai Marketing dulu.');
    }

    // SEKARANG $request SUDAH VALID
    return app(MarketingController::class)->index($request);
});

// =======================
// LOGOUT
// =======================
Route::post('/logout', function () {
    session()->forget('role');
    return redirect('/');
});

// =======================
// PREVENT GET /marketing-login
// =======================
Route::get('/marketing-login', function () {
    return redirect('/');
});


// =======================
// Executive Dashboard - Protected
// =======================
Route::middleware(['web', 'role:executive'])->group(function () {
    // MAIN DASHBOARD
    Route::get('/executive/dashboard', [ExecutiveDashboardController::class, 'index'])
        ->name('executive.dashboard');
    
    // CONTENT CRUD OPERATIONS
    Route::post('/executive/content', [ExecutiveDashboardController::class, 'create'])
        ->name('executive.content.create');
    
    Route::put('/executive/content/{identifier}', [ExecutiveDashboardController::class, 'update'])
        ->name('executive.content.update');
    
    Route::delete('/executive/content/{identifier}', [ExecutiveDashboardController::class, 'delete'])
        ->name('executive.content.delete');
    
    Route::get('/executive/content/{identifier}', [ExecutiveDashboardController::class, 'show'])
        ->name('executive.content.show');
    
    Route::post('/executive/logout', function (Request $request) {
        $request->session()->forget('role');
        return redirect('/')->with('success', 'Logout berhasil.');
    })->name('executive.logout');
});

// Biar kalau user buka /executive-login lewat browser, ga nge-trigger apa2
Route::get('/executive-login', function () {
    return redirect('/');
});



