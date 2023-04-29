<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Interfaces\SourceServiceInterface;
use App\Services\GithubSourceService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GithubSourceServiceTest extends TestCase
{
    use DatabaseMigrations;

    public SourceServiceInterface $sourceService;

    public function setUp(): void
    {
        parent::setUp();
        $this->sourceService = new GithubSourceService();
    }

    /** @test */
    public function it_should_create_a_word_statistic(): void
    {
        $this->assertTrue(true);
        $result = $this->sourceService->getWordStatistic("php");
        $this->assertNotNull($result->toArray());
    }
}
