<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $activities = PhysicalActivity::all();
        return view('home', compact('activities'));
    }
}
