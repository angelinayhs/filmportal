<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // =======================
        // 1) Explore Grid (CACHE + NOLOCK)
        // =======================
        $films = Cache::remember('home_films', 600, function () {
            return DB::select("
                SELECT TOP 80
                    show_id,
                    name,
                    genres,
                    vote_average,
                    popularity
                FROM vw_show_details WITH (NOLOCK)
                WHERE popularity > 0
                ORDER BY popularity DESC
            ");
        });

        // =======================
        // 2) Trending Now
        // =======================
        $trendingSlider = DB::table('vw_trending_content')
            ->where('trending_period', 'weekly_trending')
            ->orderByDesc('trending_score')
            ->limit(8)
            ->get();

        // =======================
        // 3) Top 10 Serial Minggu Ini
        // =======================
        $topShows = DB::table('vw_trending_content')
            ->where('trending_period', 'weekly_trending')
            ->whereRaw('(COALESCE(number_of_seasons, 0) > 0 OR COALESCE(number_of_episodes, 0) > 0)')
            ->orderByDesc('trending_score')
            ->limit(10)
            ->get();

        // =======================
        // 4) Top 10 Film Hari Ini (CACHE + NOLOCK)
        // =======================
        $topMovies = Cache::remember('top_movies_today', 600, function () {
            return DB::select("
                SELECT TOP 10
                    show_id,
                    name,
                    genres,
                    vote_average,
                    popularity
                FROM vw_show_details WITH (NOLOCK)
                WHERE popularity > 0
                ORDER BY popularity DESC
            ");
        });

        // =======================
        // 5) Daily Highlights
        // =======================
        $highlights = DB::table('vw_daily_highlights')->get();
        $filmOfTheDay = $highlights->firstWhere('highlight_type', 'film_of_the_day');

        $historyItems = $highlights->where('highlight_type', 'this_day_in_history')->values();
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
