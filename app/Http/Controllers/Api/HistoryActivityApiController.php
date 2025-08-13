<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Analytic;

class HistoryActivityApiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'duration'         => 'required|integer|min:0',
            'focus_duration'   => 'required|integer|min:0',
            'unfocus_duration' => 'required|integer|min:0',
        ]);

        $analytic = Analytic::create([
            'user_id'          => $request->user()->id,
            'duration'         => $validated['duration'],
            'focus_duration'   => $validated['focus_duration'],
            'unfocus_duration' => $validated['unfocus_duration'],
        ]);

        return response()->json([
            'success' => true,
            'status'  => 201,
            'message' => 'Data capture fokus berhasil disimpan',
            'data'    => $analytic
        ], 201);
    }
}
