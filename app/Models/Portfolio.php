<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    protected $table = 'portfolios';

    protected $fillable = [
        'title',
        'image',
        'category',     // vd: fade, tao-kieu, cao-rau, tre-em...
        'hairstyle_id',
        'barber_id',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function hairstyle(): BelongsTo
    {
        return $this->belongsTo(Hairstyle::class);
    }

    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class);
    }
}