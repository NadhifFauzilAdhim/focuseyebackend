<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Analytic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; // 1. Tambahkan use statement untuk Cache

class HistoryActivityApiController extends Controller
{
    /**
     * Menyimpan data aktivitas baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'duration'         => 'required|integer|min:0',
            'focus_duration'   => 'required|integer|min:0',
            'unfocus_duration' => 'required|integer|min:0',
            'start_time'       => 'required|date_format:Y-m-d H:i:s',
            'end_time'         => 'required|date_format:Y-m-d H:i:s|after_or_equal:start_time',
        ]);

        $analytic = Analytic::create([
            'user_id'          => $request->user()->id,
            'duration'         => $validated['duration'],
            'focus_duration'   => $validated['focus_duration'],
            'unfocus_duration' => $validated['unfocus_duration'],
            'start_time'       => $validated['start_time'],
            'end_time'         => $validated['end_time'],
        ]);

        $cacheKey = 'history_activity_user_' . $request->user()->id;
        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'status'  => 201,
            'message' => 'Data capture fokus berhasil disimpan',
            'data'    => $analytic
        ], 201);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $cacheKey = 'history_activity_user_' . $request->user()->id;
        $duration = 60 * 60; 
        $analytics = Cache::remember($cacheKey, $duration, function () use ($request) {
            return Analytic::where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        });

        return response()->json([
            'success' => true,
            'status'  => 200,
            'message' => 'Data riwayat aktivitas berhasil diambil',
            'data'    => $analytics
        ], 200);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Analytic  $analytic
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Analytic $analytic)
    {
        if ($request->user()->id !== $analytic->user_id) {
            return response()->json([
                'success' => false,
                'status'  => 403,
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk menghapus data ini.',
            ], 403);
        }

        foreach ($analytic->captureHistory as $capture) {
            if ($capture->image_path) {
                Storage::disk('public')->delete($capture->image_path);
            }
        }
        $analytic->delete();

        $cacheKey = 'history_activity_user_' . $request->user()->id;
        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'status'  => 200,
            'message' => 'Data aktivitas berhasil dihapus.',
        ], 200);
    }
}