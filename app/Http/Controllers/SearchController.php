<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $q = trim($request->get('q', ''));

        // Kalau kosong, balikin array kosong
        if ($q === '') {
            return response()->json([]);
        }

        $maxResults = 8;

        // PAKAI STORED PROCEDURE BARU
        $rows = DB::select(
            'EXEC dbo.sp_SmartContextualSearch @keyword = ?, @max_results = ?',
            [$q, $maxResults]
        );

        // Rapihin response JSON
        $results = collect($rows)->map(function ($row) {
            return [
                'source_type'      => $row->source_type,   // title / show
                'id'               => $row->id,
                'title'            => $row->title,
                'description'      => $row->description,
                'title_type'       => $row->title_type,
                'start_year'       => $row->start_year,
                'runtime_minutes'  => $row->runtime_minutes,
                'genres'           => $row->genres,
                'popularity'       => $row->popularity,
                'rating'           => $row->rating,
                'votes'            => $row->votes,
            ];
        });

        return response()->json($results);
    }
}
