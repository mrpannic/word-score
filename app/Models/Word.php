<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    const SOURCE_GITHUB = 1;

    protected $fillable = [
        'word',
        'positive_count',
        'negative_count',
        'source'
    ];
}
