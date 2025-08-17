<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Analytic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Gemini\Laravel\Facades\Gemini;

class SummaryApiController extends Controller
{
    /**
     *
     * @param Request $request
     * @param Analytic $analytic
     * @return JsonResponse
     */
    public function generateSummary(Request $request, Analytic $analytic): JsonResponse
    {
        if ($request->user()->id !== $analytic->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $analytic->load('summary');
        
        if ($analytic->summary) {
            Log::info("Mengambil ringkasan dari database untuk analytic_id: {$analytic->id}");
            return response()->json($analytic->summary, 200);
        }

        $analytic->load('captureHistory');

        if ($analytic->captureHistory->isEmpty()) {
            return response()->json(['error' => 'Tidak ada data untuk dianalisis pada sesi ini.'], 422);
        }

        $capturedTexts = $analytic->captureHistory->pluck('captured_data')->implode("\n---\n");
        $prompt = $this->createFocusAnalysisPrompt($capturedTexts, $analytic);

        try {
            Log::info("Menghasilkan ringkasan baru via API untuk analytic_id: {$analytic->id}");
            $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
                            ->generateContent($prompt);
            $aiSummaryText = $result->text();
        } catch (\Exception $e) {
            Log::error('Panggilan API Gemini gagal: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghasilkan ringkasan AI. Coba lagi nanti.'], 500);
        }
        $summary = $analytic->summary()->create([
            'ai_summary' => $aiSummaryText
        ]);
        return response()->json($summary, 201); 
    }

    /**
     *
     * @param string 
     * @param Analytic 
     * @return string
     */
    private function createFocusAnalysisPrompt(string $capturedTexts, Analytic $analytic): string
    {
        return <<<PROMPT
        Anda adalah seorang analis fokus yang bertugas memberikan laporan profesional mengenai aktivitas pengguna.
    
        **Tujuan:** Berikan analisis mengenai tingkat fokus pengguna berdasarkan data aktivitas yang tersedia.
    
        **Konteks Sesi:**
        - Durasi Total: {$analytic->duration} detik
        - Durasi Fokus: {$analytic->focus_duration} detik
        - Durasi Tidak Fokus: {$analytic->unfocus_duration} detik
        - Waktu Mulai: {$analytic->start_time}
        - Waktu Selesai: {$analytic->end_time}
    
        **Instruksi:**
        1. Tinjau data aktivitas mentah yang tercantum di bagian "Data Aktivitas".
        2. Identifikasi seberapa besar proporsi waktu fokus dibandingkan total durasi.
        3. Buat interpretasi yang mudah dipahami pengguna (misalnya: "Anda cukup fokus", "Perlu meningkatkan konsentrasi", atau "Fokus Anda sangat baik").
        4. Sajikan analisis dalam bentuk narasi singkat dan ramah, seperti seorang analis yang memberikan laporan personal.
        5. Sertakan poin-poin penting (misalnya: aktivitas utama, pola fokus, gangguan yang sering muncul).
        6. Tutup dengan saran praktis yang dapat membantu pengguna meningkatkan fokus di sesi berikutnya.
    
        **Data Aktivitas:**
        ---
        {$capturedTexts}
        ---
    
        Silakan berikan analisis fokus sesi ini secara langsung untuk pengguna.
        PROMPT;
    }
}