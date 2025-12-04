<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use Illuminate\Http\Request;

class PhysicalActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = PhysicalActivity::all();
        return view('teacher.exercise.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.exercise.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'calories_burned' => 'required|numeric|min:0',
            'intensity_level' => 'required|in:Rendah,Sedang,Tinggi',
        ]);

        PhysicalActivity::create($request->all());

        return redirect()->route('teacher.exercise.index')->with('success', 'Aktivitas fisik berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhysicalActivity $physicalActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhysicalActivity $physicalActivity)
    {
        return view('teacher.exercise.edit', compact('physicalActivity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhysicalActivity $physicalActivity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'calories_burned' => 'required|numeric|min:0',
            'intensity_level' => 'required|in:Rendah,Sedang,Tinggi',
        ]);

        $physicalActivity->update($request->all());

        return redirect()->route('teacher.exercise.index')->with('success', 'Aktivitas fisik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhysicalActivity $physicalActivity)
    {
        $physicalActivity->delete();

        return redirect()->route('teacher.exercise.index')->with('success', 'Aktivitas fisik berhasil dihapus.');
    }

    /**
     * Display trashed resources.
     */
    public function trash()
    {
        $trashedActivities = PhysicalActivity::onlyTrashed()->get();
        return view('teacher.exercise.trash', compact('trashedActivities'));
    }

    /**
     * Restore a trashed resource.
     */
    public function restore($id)
    {
        $activity = PhysicalActivity::withTrashed()->findOrFail($id);
        $activity->restore();

        return redirect()->route('teacher.exercise.trash')->with('success', 'Aktivitas fisik berhasil dipulihkan.');
    }

    /**
     * Permanently delete a resource.
     */
    public function forceDelete($id)
    {
        $activity = PhysicalActivity::withTrashed()->findOrFail($id);
        $activity->forceDelete();

        return redirect()->route('teacher.exercise.trash')->with('success', 'Aktivitas fisik berhasil dihapus permanen.');
    }
}
