<?php

namespace App\Http\Controllers\Public\Voting;

use App\Http\Controllers\Controller;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class VoteController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('voting/Vote');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
