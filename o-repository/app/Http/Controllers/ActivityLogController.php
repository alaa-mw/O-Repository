<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ShoeColors;
use Illuminate\Http\Request;
use App\Traits\ActivityLogTransformable;

class ActivityLogController extends Controller
{
    use ActivityLogTransformable;

    public function index()
    {
        $activities = $this->getActivityLogsWithRelations()->get();

        $activities =  $this->groupLogsByType(
            $activities,
            fn($activity) => $this->transformActivityLog($activity)  // Using arrow function
        );

        return response()->json([
            'data' => $activities
        ], 200);
    }

    public function filterDayActLog(Request $request)
    {
        $request->validate([
            'day' => 'required|date_format:Y-m-d'
        ]);

        $day = $request->day;
        $activities_filtered = $this->getActivityLogsWithRelations()->whereDate('created_at', $day)->get();

        $result = $this->groupLogsByType(
            $activities_filtered,
            fn($activity) => $this->transformActivityLog($activity),  // Using arrow function

        );

        return response()->json([
            'data' => $result
        ], 200);
    }
}
