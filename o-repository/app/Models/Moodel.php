<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Moodel extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_number',
        'image'
    ];

    public function shoes(): HasMany
    {
        return $this->hasMany(Shoe::class);
    }
}
