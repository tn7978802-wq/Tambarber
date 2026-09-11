<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'image_after',
        'image_before',
        'barber_id',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Danh mục hiển thị ngoài UI (khớp với sơ đồ site: Fade, Tạo kiểu, Cạo râu, Trẻ em...)
    public const CATEGORIES = [
        'fade'      => 'Fade',
        'tao-kieu'  => 'Tạo kiểu',
        'cao-rau'   => 'Cạo râu',
        'tre-em'    => 'Cắt cho trẻ em',
        'khac'      => 'Khác',
    ];

    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeCategory($query, ?string $category)
    {
        return $category && $category !== 'tat-ca'
            ? $query->where('category', $category)
            : $query;
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? 'Khác';
    }
}
