<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Word;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ScoreTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_create_a_word_from_the_source_and_return_a_score()
    {
        $this->get("api/v1/score/php?source=" . Word::SOURCE_GITHUB)
            ->assertSuccessful()
            ->assertSee(['score', 'term', 'source']);
    }

    /** @test */
    public function it_should_not_create_a_new_word_if_it_already_exists() {
        $word = Word::factory()->create();

        $this->get("api/v1/score/{$word->term}?source=" . Word::SOURCE_GITHUB)
            ->assertSuccessful()
            ->assertSee(['score', 'term', 'source']);

        $this->assertDatabaseCount('words', 1);
    }
}
