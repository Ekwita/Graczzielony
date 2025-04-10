<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivedGame extends Model
{
    protected $fillable = [
        'ranking_id',
        'position',
        'game_name',
        'game_image',
        'bgg_id',
        'hyperlink',
        'score',
        'votes',
    ];

    public function ranking(): BelongsTo
    {
        return $this->belongsTo(ArchivedRanking::class);
    }
}
