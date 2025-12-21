<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExecutiveDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // 🔒 Proteksi role
        if (session('role') !== 'executive') {
            return redirect('/')
                ->with('login_error', 'Kamu harus login sebagai Executive dulu.');
        }

        // 🎬 DATA DUMMY SEDERHANA (sementara)
        $films = collect([
            [
                'id' => 1,
                'title' => 'Inception',
                'type' => 'movie',
                'year' => 2010,
                'rating' => 8.8,
                'popularity' => 95,
                'poster' => 'https://via.placeholder.com/80x120'
            ],
            [
                'id' => 2,
                'title' => 'Interstellar',
                'type' => 'movie',
                'year' => 2014,
                'rating' => 8.6,
                'popularity' => 92,
                'poster' => 'https://via.placeholder.com/80x120'
            ],
            [
                'id' => 3,
                'title' => 'Dark',
                'type' => 'show',
                'year' => 2017,
                'rating' => 8.7,
                'popularity' => 90,
                'poster' => 'https://via.placeholder.com/80x120'
            ],
            [
                'id' => 4,
                'title' => 'Breaking Bad',
                'type' => 'show',
                'year' => 2008,
                'rating' => 9.5,
                'popularity' => 98,
                'poster' => 'https://via.placeholder.com/80x120'
            ],
        ]);

        // 👉 kirim ke blade
        return view('executive.dashboard', compact('films'));
    }
}
