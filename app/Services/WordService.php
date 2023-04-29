<?php

namespace App\Services;

use App\Models\Word;
use App\Interfaces\SourceServiceInterface;
use Exception;

class WordService {
    private SourceServiceInterface $sourceService;

    public function setSourceService($source) {
        if ($source == Word::SOURCE_GITHUB) {
            $this->sourceService = new GithubSourceService();
        }

        // add below new source services

        if (!$this->sourceService)
            throw new Exception("Unsupported Source Service", 404);

        return $this;
    }

    public function getWord($word) {
        $wordStatistic = Word::where('term', $word)->first();

        if($wordStatistic) return $wordStatistic;

        return $this->sourceService->getWordStatistic($word);
    }

    public function getSourceNameAttribute() {

    }
}
