<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
{
    // 1) Explore grid
    $films = DB::table('vw_show_details')
        ->orderByDesc('popularity')
        ->limit(80)
        ->get();

// 2. Trending & Top Charts (Fitur 5)
// =======================
// TRENDING NOW (dari vw_trending_content)
// =======================
$trendingSlider = DB::table('vw_trending_content')
    ->where('trending_period', 'weekly_trending')
    ->orderByDesc('trending_score')
    ->limit(8)
    ->get();

// =======================
// TOP 10 SERIAL MINGGU INI (dari vw_trending_content)
// =======================
$topShows = DB::table('vw_trending_content')
    ->where('trending_period', 'weekly_trending')
    ->whereRaw('(COALESCE(number_of_seasons, 0) > 0 OR COALESCE(number_of_episodes, 0) > 0)')
    ->orderByDesc('trending_score')
    ->limit(10)
    ->get();

// =======================
// TOP 10 FILM HARI INI (fallback dari vw_show_details)
// (karena di trending_content film kosong)
// =======================
$topMovies = DB::table('vw_show_details')
    ->orderByDesc('popularity')
    ->limit(10)
    ->get();
    // 5) Daily highlights
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
