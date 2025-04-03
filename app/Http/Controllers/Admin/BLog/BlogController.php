<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('blog/BlogEditor');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
