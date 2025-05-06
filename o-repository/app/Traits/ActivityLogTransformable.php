<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait ActivityLogTransformable
{
    protected function getActivityLogsWithRelations()
    {
        return ActivityLog::with([
            'user',
            'shoeColor.color',
            'shoeColor.shoe.moodel'
        ]);
    }

    protected function transformActivityLog($activity)
    {
        return [
            'id' => $activity->id,
            'type' => $activity->type,
            'shoe_color_id' => $activity->shoe_color_id,
            'user_id' => $activity->user_id,
            'quantity' => $activity->quantity,
            'created_at' => $activity->created_at->format('Y-m-d'),
            'shoe_colors' => $activity->shoeColor ? [
                'color' => $activity->shoeColor->color ? [
                    'id' => $activity->shoeColor->color->id,
                    'name' => $activity->shoeColor->color->name,
                    'hexa' => $activity->shoeColor->color->hexa,
                ] : [],
                'shoe' => $activity->shoeColor->shoe ? [
                    'shoe_number' => $activity->shoeColor->shoe->shoe_number,
                    'moodel' => [
                        'model_number' => $activity->shoeColor->shoe->moodel->model_number ?? null
                    ]
                ] : []
            ] : null
        ];
    }

    protected function groupLogsByType($activities, $transformCallback, $additionalFilters = [])
    {
        $production = $activities->where('type', 'production');
        $sales = $activities->where('type', 'sale');

        // Apply additional filters if provided
        foreach ($additionalFilters as $filter) {
            $production = $production->where(...$filter);
            $sales = $sales->where(...$filter);
        }

        return [
            'production_logs' => $production->map($transformCallback)->values(),
            'sales_logs' => $sales->map($transformCallback)->values()
        ];
    }

}
