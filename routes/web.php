<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\HomeController;



// =======================
// DATA FILM UTAMA (ROLE 1 & ROLE 2) – masih dummy untuk home & executive
// =======================
$films = [
    [
        'id' => 1,
        'title' => 'Inception',
        'type' => 'movie',
        'year' => 2010,
        'genres' => ['Sci-Fi', 'Thriller'],
        'country' => 'USA',
        'rating' => 8.8,
        'runtime' => 148,
        'language' => 'English',
        'is_adult' => false,
        'cast' => ['Leonardo DiCaprio', 'Joseph Gordon-Levitt'],
        'director' => 'Christopher Nolan',
        'poster' => 'https://m.media-amazon.com/images/I/51v5ZpFyaFL._AC_.jpg',
        'summary' => 'A thief steals corporate secrets using dream-sharing technology and is given a chance to erase his past crimes.',
        'tags' => ['dream', 'heist', 'mind-bending'],
        'popularity' => 97,
        'reviews' => [
            ['text' => 'Mind-blowing and emotional.', 'sentiment' => 'positive'],
            ['text' => 'Too confusing in the middle.', 'sentiment' => 'negative'],
        ],
    ],
    [
        'id' => 2,
        'title' => 'Shutter Island',
        'type' => 'movie',
        'year' => 2010,
        'genres' => ['Mystery', 'Thriller'],
        'country' => 'USA',
        'rating' => 8.1,
        'runtime' => 138,
        'language' => 'English',
        'is_adult' => false,
        'cast' => ['Leonardo DiCaprio', 'Mark Ruffalo'],
        'director' => 'Martin Scorsese',
        'poster' => 'https://m.media-amazon.com/images/I/51rcL8N1xXL._AC_.jpg',
        'summary' => 'Two US marshals investigate a psychiatric facility on a remote island.',
        'tags' => ['island', 'mental', 'twist'],
        'popularity' => 90,
        'reviews' => [
            ['text' => 'Ending twist is unforgettable.', 'sentiment' => 'positive'],
            ['text' => 'Slow burn, not for everyone.', 'sentiment' => 'neutral'],
        ],
    ],
    [
        'id' => 3,
        'title' => 'Dark',
        'type' => 'show',
        'year' => 2017,
        'genres' => ['Sci-Fi', 'Mystery'],
        'country' => 'Germany',
        'rating' => 8.7,
        'runtime' => 60,
        'language' => 'German',
        'is_adult' => false,
        'cast' => ['Louis Hofmann'],
        'director' => 'Baran bo Odar',
        'poster' => 'https://m.media-amazon.com/images/I/81V+Zk1c83L._AC_SY679_.jpg',
        'summary' => 'A time-travel mystery that spans multiple generations in a small German town.',
        'tags' => ['time travel', 'family', 'loop'],
        'popularity' => 93,
        'reviews' => [
            ['text' => 'Best time-travel show ever.', 'sentiment' => 'positive'],
        ],
    ],
    [
        'id' => 4,
        'title' => 'Interstellar',
        'type' => 'movie',
        'year' => 2014,
        'genres' => ['Sci-Fi', 'Drama'],
        'country' => 'USA',
        'rating' => 8.6,
        'runtime' => 169,
        'language' => 'English',
        'is_adult' => false,
        'cast' => ['Matthew McConaughey', 'Anne Hathaway'],
        'director' => 'Christopher Nolan',
        'poster' => 'https://m.media-amazon.com/images/I/71n58sLecmL._AC_SY741_.jpg',
        'summary' => 'Explorers travel through a wormhole in space to ensure humanity’s survival.',
        'tags' => ['space', 'father-daughter'],
        'popularity' => 95,
        'reviews' => [
            ['text' => 'Emotional and visually stunning.', 'sentiment' => 'positive'],
        ],
    ],
    [
        'id' => 5,
        'title' => 'La La Land',
        'type' => 'movie',
        'year' => 2016,
        'genres' => ['Romance', 'Drama'],
        'country' => 'USA',
        'rating' => 8.0,
        'runtime' => 128,
        'language' => 'English',
        'is_adult' => false,
        'cast' => ['Emma Stone', 'Ryan Gosling'],
        'director' => 'Damien Chazelle',
        'poster' => 'https://m.media-amazon.com/images/I/71z3MxyQ8uL._AC_SY679_.jpg',
        'summary' => 'A jazz pianist and an aspiring actress fall in love while pursuing their dreams.',
        'tags' => ['music', 'dreams'],
        'popularity' => 85,
        'reviews' => [
            ['text' => 'Music and colors are perfect.', 'sentiment' => 'positive'],
        ],
    ],
    [
        'id' => 6,
        'title' => 'Breaking Bad',
        'type' => 'show',
        'year' => 2008,
        'genres' => ['Crime', 'Drama'],
        'country' => 'USA',
        'rating' => 9.5,
        'runtime' => 47,
        'language' => 'English',
        'is_adult' => true,
        'cast' => ['Bryan Cranston', 'Aaron Paul'],
        'director' => 'Vince Gilligan',
        'poster' => 'https://m.media-amazon.com/images/I/71sBtM3Yi5L._AC_SY679_.jpg',
        'summary' => 'A chemistry teacher turns to making methamphetamine after a cancer diagnosis.',
        'tags' => ['crime', 'anti-hero'],
        'popularity' => 99,
        'reviews' => [
            ['text' => 'One of the best shows ever made.', 'sentiment' => 'positive'],
        ],
    ],
];

// =======================
// ROLE 1 – NATIVE USER (HALAMAN UTAMA)
// =======================
Route::get('/', function () use ($films) {
    return view('home', compact('films'));
});

// =======================
// LOGIN EXECUTIVE (ROLE 2)
// =======================

// proses login dari modal di halaman utama
Route::post('/executive-login', function (Request $request) {

    // SEMENTARA: hardcode akun executive
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'exec@studio.com' && $password === 'password123') {
        session(['role' => 'executive']);
        return redirect('/executive');
    }

    // kalau gagal, balik ke home dengan error message
    return redirect('/')
        ->with('login_error', 'Email atau password executive salah.');
});

// halaman dashboard executive
Route::get('/executive', function () use ($films) {
    if (session('role') !== 'executive') {
        return redirect('/')
            ->with('login_error', 'Kamu harus login sebagai Executive dulu.');
    }

    // di sini nanti bisa kirim data lain juga (analytics, dsb)
    return view('executive.dashboard', compact('films'));
});

// logout executive
Route::post('/logout', function () {
    session()->forget('role');
    return redirect('/');
});

// =======================
// ROUTE BARU UNTUK ROLE 1
// =======================

// Halaman detail film (VERSI LAMA, PAKAI ARRAY $films)
Route::get('/film/{id}', function ($id) use ($films) {
    $film = collect($films)->firstWhere('id', (int)$id);
    
    if (!$film) {
        abort(404);
    }

    $recommendations = collect($films)
        ->where('id', '!=', $film['id'])
        ->filter(function ($item) use ($film) {
            return count(array_intersect($item['genres'], $film['genres'])) > 0 ||
                   $item['director'] === $film['director'] ||
                   count(array_intersect($item['cast'], $film['cast'])) > 0;
        })
        ->take(6);

    return view('film-detail', compact('film', 'recommendations'));
});





Route::get('/api/search-suggestions', [SearchController::class, 'suggestions']);
Route::get('/film/{id}', [ShowController::class, 'detail']);
Route::get('/', [HomeController::class, 'index']);


