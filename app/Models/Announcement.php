<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'event_at',
        'is_pinned',
    ];

    protected $casts = [
        'event_at' => 'datetime',
        'is_pinned' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderByDesc('is_pinned')->orderByDesc('created_at');
    }
}
