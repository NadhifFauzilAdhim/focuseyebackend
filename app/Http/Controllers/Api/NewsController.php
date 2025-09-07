<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NewsApiService;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    protected $newsApiService;

    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }

    /**
     * Fetch news data from News API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNews(Request $request)
    {
        $cacheKey = 'news.pendidikan-anak';
        $cacheDuration = 60 * 12; 

        $response = Cache::remember($cacheKey, $cacheDuration, function () {
            return $this->newsApiService->fetchNews('Pendidikan Anak');
        });

        return response()->json($response);
    }
}
