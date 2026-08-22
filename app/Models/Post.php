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
        'category',   // vd: kien-thuc, huong-dan, tin-tuc
        'status',     // draft | published
        'publish_at',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(function (Builder $builder) {
                $builder->whereNull('publish_at')->orWhere('publish_at', '<=', now());
            });
    }
}