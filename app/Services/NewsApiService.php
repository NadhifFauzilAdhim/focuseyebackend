<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class NewsApiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
        $this->baseUrl = 'https://newsapi.org/v2/everything';
    }

    /**
     * Fetch news based on a query.
     *
     * @param string $query
     * @return array
     */
    public function fetchNews(string $query): array
    {
        $fromDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $response = Http::get($this->baseUrl, [
            'q' => $query,
            'from' => $fromDate,
            'sortBy' => 'publishedAt',
            'apiKey' => $this->apiKey,
        ]);

        return $response->json();
    }
}
