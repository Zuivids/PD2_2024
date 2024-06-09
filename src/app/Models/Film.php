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
        'genre_id',
        'description',
        'rating',
        'price',
        'year',

    ];

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'producer' => $this->producer->name,
            //TODO
            'genre' => ($this->genre ? $this->genre->name : ''),   
            //'price' => number_format($this->price, 2),
            'rating' => number_format($this->rating, 1),
            'year' => intval($this->year),
            'image' => asset('images/' . $this->image),
        ];
    }
}
