<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'brand',
        'unit',
        'stock_quantity',
        'min_stock_alert',
        'location',
        'description',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'stock_quantity' => 'decimal:3',
            'min_stock_alert' => 'decimal:3',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(InventoryTransactionItem::class);
    }
}
