<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $casts = [
        'publish_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'category',
        'status',
        'publish_at',
    ];

    public static function syncScheduledStatuses(): void
    {
        static::query()
            ->where('status', 'scheduled')
            ->whereNotNull('publish_at')
            ->where('publish_at', '<=', now())
            ->update(['status' => 'published']);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereIn('status', ['published', 'scheduled'])
            ->where(function (Builder $builder) {
                $builder->whereNull('publish_at')
                       ->orWhere('publish_at', '<=', now());
            });
    }
}