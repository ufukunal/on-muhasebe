<?php

namespace App\Http\Controllers\front\home;

use App\Logger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        $logger = Logger::orderBy('created_at', 'desc')->limit(10)->get();
        return view('front.home.index')->with('logger', $logger);
    }
}
