<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Shoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoe_number',
        'image'
    ];

    public function models(): BelongsTo
    {
        return $this->belongsTo(Moodel::class);
    }

    public function shoeColors(){
        return $this->HasMany(ShoeColors::class,'shoe_id');
    }
}
