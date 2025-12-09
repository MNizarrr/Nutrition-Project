<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $activities = PhysicalActivity::where('status', 'active')->latest()->take(4)->get();
        return view('home', compact('activities'));
    }

    public function allActivities(Request $request)
    {
        $search = $request->get('search_exercise');

        $query = PhysicalActivity::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        $activities = $query->latest()->get();

        return view('exercise', compact('activities', 'search'));
    }
}
