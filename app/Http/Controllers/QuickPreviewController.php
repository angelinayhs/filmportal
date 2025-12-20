<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QuickPreviewController extends Controller
{
    public function show($id)
    {
        $data = DB::table('vw_quick_preview')
            ->where('show_id', $id)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($data);
    }
}
