<?php

namespace App\Http\Controllers\Api;

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
        ]);

        $imageManager = new ImageManager(new Driver());
        $imageFile = $request->file('image');
        $image     = $imageManager->read($imageFile->getRealPath());

        $image->scaleDown(1080, 1080);
        $image->scaleDown(width: 327);

        $fileName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $path     = storage_path('app/public/captures/' . $fileName);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $image->save($path);

        $capture = CaptureHistory::create([
            'analytic_id' => $validated['analytic_id'],
            'image_path'  => 'captures/' . $fileName, 
        ]);

        return response()->json([
            'success' => true,
            'status'  => 201,
            'message' => 'Capture berhasil disimpan dengan kompresi',
            'data'    => $capture
        ], 201);
    }
}
