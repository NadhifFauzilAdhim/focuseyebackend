<?php

namespace App\Http\Controllers\Api;

use App\Models\Analytic;
use Illuminate\Http\Request;
use App\Models\CaptureHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache; 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class CaptureHistoryApiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'analytic_id' => 'required|exists:analytics,id',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'capture_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $imageManager = new ImageManager(new Driver());
        $imageFile = $request->file('image');
        $image     = $imageManager->read($imageFile->getRealPath());

        $image->scaleDown(width: 327);

        $fileName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $directory = 'captures';
        
        Storage::disk('public')->put($directory . '/' . $fileName, (string) $image->encode());

        $capture = CaptureHistory::create([
            'analytic_id'  => $validated['analytic_id'],
            'image_path'   => $directory . '/' . $fileName,
            'capture_time' => $validated['capture_time'],
        ]);

        $cacheKey = 'capture_history_analytic_' . $validated['analytic_id'];
        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'status'  => 201,
            'message' => 'Capture berhasil disimpan dengan kompresi',
            'data'    => $capture
        ], 201);
    }

    /**
     *
     * @param  int  $analytic_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($analytic_id)
    {
        $analytic = Analytic::find($analytic_id);
        if (!$analytic) {
            return response()->json([
                'success' => false,
                'status'  => 404,
                'message' => 'Analytic ID tidak ditemukan.',
            ], 404);
        }
        $cacheKey = 'capture_history_analytic_' . $analytic_id;
        $duration = 60 * 60; 

        $captures = Cache::remember($cacheKey, $duration, function () use ($analytic_id) {
            return CaptureHistory::where('analytic_id', $analytic_id)
                ->orderBy('created_at', 'desc')
                ->get();
        });

        return response()->json([
            'success' => true,
            'status'  => 200,
            'message' => 'Data capture berhasil diambil',
            'data'    => $captures
        ], 200);
    }
}