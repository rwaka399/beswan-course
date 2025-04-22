<?php

namespace App\Http\Controllers;

use App\Models\LessonPackage;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        $lessonPackages = LessonPackage::all();

        return view('home', compact('lessonPackages'));
        // return view('home');
    }

    public function dashboard()
    {
        return view('master.dashboard');
    }
}
