<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SamplePageController extends Controller
{
    public function index()
    {
        return view('sample');
    }
}
