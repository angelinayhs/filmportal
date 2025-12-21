<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $q = trim($request->get('q', ''));

        if ($q === '') {
            return response()->json([]);
        }

        $maxResults = 8;

        $rows = DB::select(
            'EXEC dbo.sp_SmartContextualSearch @keyword = ?, @max_results = ?',
            [$q, $maxResults]
        );

        $results = collect($rows)->map(function ($row) {
            // sp kamu ngembaliin: source_type = 'title' / 'show'
            // FE kamu ngarep: result_type = 'person' / 'show'
            $type = $row->source_type ?? 'show';

            return [
                // ✅ yang dipakai frontend
                'result_type' => $type,                 // 'show' atau 'title'
                'id'          => $row->id,
                'title'       => $row->title,
                'genres'      => $row->genres,

                // optional tambahan kalau masih dipakai
                'source_type'     => $type,
                'description'     => $row->description,
                'title_type'      => $row->title_type,
                'start_year'      => $row->start_year,
                'runtime_minutes' => $row->runtime_minutes,
                'popularity'      => $row->popularity,
                'rating'          => $row->rating,
                'votes'           => $row->votes,
            ];
        });

        return response()->json($results->values());
    }
}
