<?php

namespace App\Http\Controllers\Admin\Blog;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
