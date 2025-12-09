<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use App\Models\PhysicalActivity;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function bmiChart()
    {
        // Get monthly BMI records for the current year
        $currentYear = now()->year;
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $count = BmiRecord::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            $monthlyData[] = $count;
        }

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        return response()->json([
            'labels' => $labels,
            'data' => $monthlyData
        ]);
    }

    public function activitiesChart()
    {
        $active = PhysicalActivity::where('status', 'active')->count();
        $inactive = PhysicalActivity::where('status', 'inactive')->count();

        return response()->json([
            'data' => [$active, $inactive]
        ]);
    }

    public function activeUsersChart()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $activeUsersCount = \App\Models\UserExerciseSession::whereYear('started_at', $currentYear)
            ->whereMonth('started_at', $currentMonth)
            ->distinct('user_id')
            ->count('user_id');

        return response()->json([
            'data' => $activeUsersCount
        ]);
    }
}
