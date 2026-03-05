<?php

namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about()
    {
        return view('about.about');
    }

    public function tutorial()
    {
        return view('about.tutorial');
    }
}
