<?php

namespace App\Http\Controllers\Public\Ranking;

use App\Http\Controllers\Controller;
use App\Models\Podium;
use App\Models\Vote;

class PodiumContoller extends Controller
{
    public function store()
    {
        Podium::create();

        Vote::delete();
    }
}
