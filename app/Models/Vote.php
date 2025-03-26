<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'game_id',
        'points',
        'user_name',
        'email',
        'voted_at',
    ];
}
