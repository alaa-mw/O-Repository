<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Models\ShoeColors;

trait createActivityLog
{
    protected function createActivityLog(
        string $type,
        ShoeColors $shoeColor,
        int $quantity,
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'shoe_color_id' => $shoeColor->id,
            'type' => $type,
            'quantity' => $quantity,
        ]);
    }
}
