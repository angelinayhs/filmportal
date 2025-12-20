<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketingController;

// =======================
// ROLE 1 – HOME (DB)
// =======================
Route::get('/', [HomeController::class, 'index']);

// =======================
// DETAIL SHOW (DB)
// =======================
Route::get('/film/{id}', [ShowController::class, 'detail']);

// =======================
// SEARCH SUGGESTIONS (API style tapi boleh di web.php)
// =======================
Route::get('/api/search-suggestions', [SearchController::class, 'suggestions']);

// =======================
// LOGIN EXECUTIVE (ROLE 2)
// =======================
Route::post('/executive-login', function (Request $request) {

    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'exec@studio.com' && $password === 'password123') {
        session(['role' => 'executive']);
        return redirect('/executive');
    }

    return redirect('/')
        ->with('login_error', 'Email atau password executive salah.');
});

Route::get('/executive', function () {
    if (session('role') !== 'executive') {
        return redirect('/')
            ->with('login_error', 'Kamu harus login sebagai Executive dulu.');
    }

    return view('executive.dashboard');
});

Route::post('/logout', function () {
    session()->forget('role');
    return redirect('/');
});


Route::get('/marketing', [MarketingController::class, 'index']);