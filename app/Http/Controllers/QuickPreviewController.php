<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QuickPreviewController extends Controller
{
    public function show($id)
    {
        $item = DB::table('vw_quick_preview')
            ->where('show_id', $id)
            ->first();

        if (!$item) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($item);
    }
}
