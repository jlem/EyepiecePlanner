<?php

namespace EPP\Http\Controllers;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin.home');
    }
}