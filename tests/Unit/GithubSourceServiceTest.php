<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Interfaces\SourceServiceInterface;
use App\Services\GithubSourceService;

class GithubSourceServiceTest extends TestCase
{
    public SourceServiceInterface $sourceService;

    public function setUp(): void
    {
        parent::setUp();
        $this->sourceService = new GithubSourceService();
    }

    /** @test */
    public function it_should_return_word_count_breakdown(): void
    {
        $result = $this->sourceService->getWordStatistic("php");
        $this->assertArrayHasKey('positiveCount', $result);
        $this->assertArrayHasKey('negativeCount', $result);
    }
}
