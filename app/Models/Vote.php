<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'game_id',
        'points',
        'user_name',
        'email',
        'voted_at',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
