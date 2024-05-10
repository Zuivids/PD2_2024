<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Film extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'producer_id',
        'description',
        'price',
        'year',
    ];

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }
}
