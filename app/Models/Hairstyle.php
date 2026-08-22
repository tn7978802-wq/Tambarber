<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hairstyle extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'suitable_face_shapes', // vd: "Vuông, Tròn"
        'difficulty',           // easy | medium | hard
        'reference_price',
    ];

    protected $casts = [
        'reference_price' => 'decimal:0',
    ];

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }
}