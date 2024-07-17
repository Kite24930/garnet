<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rank_id',
        'category_id',
        'group_id',
        'task',
    ];
}
