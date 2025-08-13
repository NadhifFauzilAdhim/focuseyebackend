<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CaptureHistory;
use App\Http\Controllers\Controller;

class CaptureHistoryApiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'analytic_id' => 'required|exists:analytics,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        $path = $request->file('image')->store('captures', 'public');

        $capture = CaptureHistory::create([
            'analytic_id' => $validated['analytic_id'],
            'image_path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'status' => 201,
            'message' => 'Capture berhasil disimpan',
            'data' => $capture
        ], 201);
    }
}
