<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podium extends Model
{
    protected $fillable = [
        'date',
        'bgg_id',
        'name',
        'hyperlink',
        'score',
        'image',
        'votes'
    ];
}
