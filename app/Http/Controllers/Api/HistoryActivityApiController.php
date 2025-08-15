<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Analytic;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Mengambil riwayat data aktivitas untuk pengguna yang diautentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $analytics = Analytic::where('user_id', $request->user()->id)
                             ->orderBy('created_at', 'desc')
                             ->get();

        return response()->json([
            'success' => true,
            'status'  => 200,
            'message' => 'Data riwayat aktivitas berhasil diambil',
            'data'    => $analytics
        ], 200);
    }

    /**
     * Menghapus data aktivitas beserta file gambar terkait.
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

        return response()->json([
            'success' => true,
            'status'  => 200,
            'message' => 'Data aktivitas berhasil dihapus.',
        ], 200);
    }
}
