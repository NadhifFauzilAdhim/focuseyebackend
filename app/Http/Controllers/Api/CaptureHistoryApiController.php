<?php

namespace App\Http\Controllers\Api;

use App\Models\Analytic;
use Illuminate\Http\Request;
use App\Models\CaptureHistory;
use App\Http\Controllers\Controller;
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
        
        // Simpan gambar menggunakan Laravel Storage facade
        Storage::disk('public')->put($directory . '/' . $fileName, (string) $image->encode());

        $capture = CaptureHistory::create([
            'analytic_id' => $validated['analytic_id'],
            'image_path'  => $directory . '/' . $fileName,
            'capture_time' => $validated['capture_time'],
        ]);

        return response()->json([
            'success' => true,
            'status'  => 201,
            'message' => 'Capture berhasil disimpan dengan kompresi',
            'data'    => $capture
        ], 201);
    }

    /**
     * Mengambil riwayat capture untuk analytic_id tertentu.
     *
     * @param  int  $analytic_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($analytic_id)
    {
        // Cek apakah analytic record ada
        if (!Analytic::find($analytic_id)) {
            return response()->json([
                'success' => false,
                'status'  => 404,
                'message' => 'Analytic ID tidak ditemukan.',
            ], 404);
        }

        $captures = CaptureHistory::where('analytic_id', $analytic_id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return response()->json([
            'success' => true,
            'status'  => 200,
            'message' => 'Data capture berhasil diambil',
            'data'    => $captures
        ], 200);
    }
}
