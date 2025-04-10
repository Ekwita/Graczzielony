<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchivedRanking extends Model
{
    protected $fillable = [
        'winner_name',
        'winner_image',
        'month',
    ];

    protected $casts = [
        'month' => 'date',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(ArchivedGame::class);
    }
}
