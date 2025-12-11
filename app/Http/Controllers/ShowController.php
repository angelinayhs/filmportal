<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function detail($id)
    {
        // 1) Ambil detail utama dari view vw_show_details
        $film = DB::table('vw_show_details')
            ->where('show_id', $id)
            ->first();

        if (!$film) {
            abort(404, 'Show tidak ditemukan');
        }

        // 2) Panggil stored procedure rekomendasi
        $maxResults = 8;

        $rows = DB::select(
            'EXEC dbo.sp_cross_media_recommendations ?, ?',
            [$id, $maxResults]
        );

        // 3) Ambil daftar recommended_show_id
        $recommendationIds = collect($rows)
            ->pluck('recommended_show_id')
            ->unique()
            ->values();

        // 4) Ambil detail show lengkap untuk rekomendasi dari vw_show_details juga
        if ($recommendationIds->isEmpty()) {
            $recommendations = collect();
        } else {
            $recommendations = DB::table('vw_show_details')
                ->whereIn('show_id', $recommendationIds->toArray())
                ->get();
        }

        // 5) Kirim ke view
        return view('film-detail', [
            'film'            => $film,
            'recommendations' => $recommendations,
        ]);
    }
}
