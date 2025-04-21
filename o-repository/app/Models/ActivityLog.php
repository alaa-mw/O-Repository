<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'shoe_color_id',
        'user_id',
        'quantity',
        'details',
    ];

    public function shoeColors()
    {
        return $this->belongsTo(ShoeColors::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
