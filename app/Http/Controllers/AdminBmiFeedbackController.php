<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use Illuminate\Http\Request;

class AdminBmiFeedbackController extends Controller
{
    public function index()
    {
        $records = BmiRecord::with('user')->orderBy('record_date', 'desc')->get();
        return view('admin.feedback.index', compact('records'));
    }

    public function update(Request $request, BmiRecord $bmiRecord)
    {
        $request->validate([
            'admin_status' => 'required|in:pending,approved,rejected',
            'admin_message' => 'nullable|string|max:1000',
        ]);

        $bmiRecord->update([
            'admin_status' => $request->admin_status,
            'admin_message' => $request->admin_message,
        ]);

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback updated successfully.');
    }
}
