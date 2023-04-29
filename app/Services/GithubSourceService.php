<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Interfaces\SourceServiceInterface;
use App\Models\Word;

class GithubSourceService implements SourceServiceInterface {

    private const SERVICE_URI = "https://api.github.com/search/issues";
    private $headers = [];


    function __construct()
    {
        $this->setHeader("Accept", "vnd.github.text-match+json");
    }

    public function setHeader($key, $value) {
        $this->headers[$key] = $value;
        return $this;
    }

    public function getWordStatistic($word)
    {
        $response = Http::withHeaders($this->headers)
            ->get(self::SERVICE_URI, [ 'q' =>  "q=$word rocks is:issue"]); // check how to get all the data required

        $positiveCount = $negativeCount = 0;
        if ($response->successful())
            $positiveCount = json_decode($response->body(), true)['total_count'];

        $response = Http::withHeaders($this->headers)
            ->get(self::SERVICE_URI, [ 'q' =>  "q=$word sucks is:issue"]);

        if ($response->successful())
            $negativeCount = json_decode($response->body(), true)['total_count'];


        return Word::create([
            'word' => $word,
            'positive_count' => $positiveCount,
            'negative_count' => $negativeCount,
            'source' => Word::SOURCE_GITHUB
        ]);
    }
}
