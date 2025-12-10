<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BmiRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = BmiRecord::where('user_id', Auth::id())->orderBy('record_date', 'desc')->get();
        return view('history', compact('records'));
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
        // try = mencoba menjalankan kode yang berpotensi error.
        // catch = menangkap error yang terjadi dan menanganinya dengan aman (misalnya menampilkan pesan error atau mengembalikan response khusus).
        try {
            $request->validate([
                'height' => 'required|numeric|min:0.5|max:3',
                'weight' => 'required|numeric|min:1|max:500',
            ]);

            $height = $request->height;
            $weight = $request->weight;
            $bmi = $weight / ($height * $height);

            $category = $this->getBmiCategory($bmi);

            BmiRecord::create([
                'user_id' => Auth::id(),
                'height' => $height,
                'weight' => $weight,
                'bmi_value' => round($bmi, 2),
                'bmi_category' => $category,
                'record_date' => now(),
                'admin_status' => 'pending',
                'teacher_checked' => false,
            ]);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'BMI record saved successfully.']);
            }

            return redirect()->route('history')->with('success', 'BMI record saved successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BmiRecord $bmiRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BmiRecord $bmiRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BmiRecord $bmiRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BmiRecord $bmiRecord)
    {
        //
    }

    private function getBmiCategory($bmi)
    {
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }
}
