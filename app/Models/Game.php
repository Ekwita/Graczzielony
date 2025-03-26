<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'bgg_id',
        'name',
        'hyperlink',
        'score',
        'image',
        'votes'
    ];
}
