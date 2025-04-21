<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoeColors extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoe_id',
        'color_id',
        'avaliable_amount',
        'sold_amount',
        'total_amount'
    ];

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function activityLog(){
        return $this->hasMany(ActivityLog::class);
    }
}
