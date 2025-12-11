<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $q = trim($request->get('q', ''));

        // kalau kosong, balikin array kosong aja
        if ($q === '') {
            return response()->json([]);
        }

        // PAKAI STORED PROCEDURE
        $maxResults = 8;

        $rows = DB::select('EXEC dbo.sp_search_suggestions ?, ?', [
            $q,
            $maxResults,
        ]);

        // DB::select ngasih array of stdClass, kita rapihin dulu
        $results = collect($rows)->map(function ($row) {
            return [
                'result_type' => $row->result_type,   // 'show' / 'person'
                'id'          => $row->id,            // string (bisa 1, 2, nm0178..., dll)
                'title'       => $row->title,
                'description' => $row->description,
                'genres'      => $row->genres,
                'popularity'  => $row->popularity,
                'rating'      => $row->rating,
            ];
        });

        return response()->json($results);
    }
}
