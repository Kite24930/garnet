<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'opponent',
        'place',
        'match_number',
        'score_us',
        'score_opponent',
        'result',
        'comment',
        'game_score_book_1',
        'game_score_book_2',
    ];
}
