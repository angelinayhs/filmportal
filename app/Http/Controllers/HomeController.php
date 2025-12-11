<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Data utama untuk grid Explore
        $films = DB::table('vw_show_details')
            ->orderByDesc('popularity')
            ->limit(80)
            ->get();

        // 2. Trending & Top Charts (Fitur 5)
        $trendingRaw = collect(DB::select(
            'EXEC dbo.sp_get_trending_content ?, ?, ?',
            ['weekly_trending', null, 40]
        ));

        $trendingSlider = $trendingRaw->take(8);

        $topMovies = $trendingRaw
            ->where('type_name', 'Scripted')
            ->values()
            ->take(10);

        $topShows = $trendingRaw
            ->where('type_name', '!=', 'Scripted')
            ->values()
            ->take(10);

        // 3. DAILY HIGHLIGHTS (Fitur 6)
        $highlights = DB::table('vw_daily_highlights')->get();

        // film_of_the_day → 1 item (boleh null)
        $filmOfTheDay = $highlights->firstWhere('highlight_type', 'film_of_the_day');

        // this_day_in_history → bisa banyak item
        $historyItems = $highlights
            ->where('highlight_type', 'this_day_in_history')
            ->values();

        // Bagi jadi 2 kolom
        $half = (int) ceil($historyItems->count() / 2);
        $historyLeft  = $historyItems->slice(0, $half)->values();
        $historyRight = $historyItems->slice($half)->values();

        return view('home', compact(
            'films',
            'trendingSlider',
            'topMovies',
            'topShows',
            'filmOfTheDay',
            'historyLeft',
            'historyRight'
        ));
    }
}
