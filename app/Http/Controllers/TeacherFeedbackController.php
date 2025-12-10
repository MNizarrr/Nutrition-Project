<?php

namespace App\Http\Controllers;

use App\Models\TeacherFeedback;
use App\Models\User;
use App\Models\BmiRecord;
use Illuminate\Http\Request;

class TeacherFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display user progress for teachers.
     */
    public function progress()
    {
        $users = User::where('role_id', 3)
            ->with(['bmiRecords' => function($query) {
                $query->orderBy('record_date', 'desc')->limit(1);
            }])->get();

        return view('teacher.progress', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherFeedback $teacherFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherFeedback $teacherFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherFeedback $teacherFeedback)
    {
        //
    }

    /**
     * Toggle teacher checked status for BMI record.
     */
    public function toggleChecked(Request $request, $recordId)
    {
        $record = BmiRecord::findOrFail($recordId);

        // Toggle the teacher_checked status
        $record->teacher_checked = !$record->teacher_checked;
        $record->save();

        return redirect()->back()->with('success', 'Progress status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherFeedback $teacherFeedback)
    {
        //
    }
}
