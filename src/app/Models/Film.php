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

    public function jsonSerialize(): mixed
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'producer' => $this->producer->name,
            //TODO
            // 'genre' => ($this->genre ? $this->genre->name : ''),   
            //'price' => number_format($this->price, 2),
            // 'raiting' => number_format($this->raiting, 1),
            'year' => intval($this->year),
            'image' => asset('images/' . $this->image),
        ];
    }
}
