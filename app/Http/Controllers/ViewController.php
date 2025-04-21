<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        return view('master.dashboard');
    }
}
