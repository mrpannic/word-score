<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    // SOURCES
    const SOURCE_GITHUB = 1;

    // SCORE
    const SCORE_LOWER_RANGE = 0;
    const SCORE_UPPER_RANGE = 10;

    protected $fillable = [
        'term',
        'positive_count',
        'negative_count',
        'source'
    ];

    public function getScoreAttribute() {
        return round($this->positive_count / ($this->positive_count + $this->negative_count) *
            (self::SCORE_UPPER_RANGE - self::SCORE_LOWER_RANGE) + self::SCORE_LOWER_RANGE,
            2
        );
    }

    public function getSourceNameAttribute() {
        $mapper = [
            self::SOURCE_GITHUB => "GitHub",
        ];

        return isset($mapper[$this->source]) ? $mapper[$this->source] : null;
    }
}
