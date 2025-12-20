<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // FITUR 1: Audience Segmentation
        // =========================
        $genreSegments = DB::select("EXEC dbo.sp_get_audience_segmentation ?, ?, ?", [
            'genre', null, null
        ]);

        $ratingSegments = DB::select("EXEC dbo.sp_get_audience_segmentation ?, ?, ?", [
            'audience_rating', null, null
        ]);

        $durationSegments = DB::select("EXEC dbo.sp_get_audience_segmentation ?, ?, ?", [
            'duration', null, null
        ]);

        // =========================
        // FITUR 2: Campaign Performance (pakai filter dari form GET)
        // =========================
        $period   = $request->query('period');               // 'Last 7 Days' / 'Last 30 Days' / 'Older' / null
        $typeName = $request->query('type');                 // contoh: 'Scripted'
        $minScore = $request->query('min_score');            // contoh: 10
        $limit    = (int) ($request->query('limit', 50));    // default 50

        // kalau kosong string -> null biar SP kebaca
        $period   = $period   !== '' ? $period : null;
        $typeName = $typeName !== '' ? $typeName : null;
        $minScore = $minScore !== '' ? (float) $minScore : null;

        $campaign = DB::select("EXEC dbo.sp_get_campaign_performance ?, ?, ?, ?", [
            $period, $minScore, $typeName, $limit
        ]);

        return view('marketing', [
            'genreSegments'    => $genreSegments,
            'ratingSegments'   => $ratingSegments,
            'durationSegments' => $durationSegments,

            'campaign' => $campaign,

            // biar value filter tetap nempel di form
            'period'   => $period,
            'typeName' => $typeName,
            'minScore' => $minScore,
            'limit'    => $limit,
        ]);
    }
}
