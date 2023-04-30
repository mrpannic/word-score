<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Interfaces\SourceServiceInterface;
use App\Models\Word;

class GithubSourceService implements SourceServiceInterface {

    private const SERVICE_URI = "https://api.github.com/search/issues";
    private $headers = [];

    const POSITIVE_KEYWORD = "rocks";
    const NEGATIVE_KEYWORD = "sucks";

    function __construct()
    {
        $this->setHeader("Accept", "vnd.github.text-match+json");
        $token = env("GITHUB_TOKEN");
        if($token)
            $this->setHeader('Authorization', "Bearer " . $token);
    }

    private function setHeader($key, $value) {
        $this->headers[$key] = $value;
        return $this;
    }

    public function getWordStatistic($word): array
    {
        $positiveCount = $this->getSpecificStatisticCount($word);
        $negativeCount = $this->getSpecificStatisticCount($word, self::NEGATIVE_KEYWORD);

        return compact('positiveCount', 'negativeCount');
    }

    private function getSpecificStatisticCount($word, $keyword = self::POSITIVE_KEYWORD): int {
        $response = Http::withHeaders($this->headers)
            ->get(self::SERVICE_URI, [ 'q' => "$word $keyword is:issue"]);

        if($response->successful())
            return json_decode($response->body(), true)['total_count'];

        return 0;
    }
}
