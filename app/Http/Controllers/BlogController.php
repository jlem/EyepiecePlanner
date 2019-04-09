<?php

namespace EPP\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index');
    }

    public function details($entry, $page)
    {
        return view('blog.details', compact('entry', 'page'));
    }
}
