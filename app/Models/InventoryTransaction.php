<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryTransaction extends Model
{
    use HasFactory;

    public const TYPE_IMPORT = 'import';

    public const TYPE_EXPORT = 'export';

    public const TYPE_ADJUSTMENT = 'adjustment';

    protected $fillable = [
        'transaction_code',
        'type',
        'project_or_supplier_name',
        'supplier_id',
        'project_id',
        'user_id',
        'transaction_date',
        'note',
        'status',
    ];

    protected function casts(): array
    {
        return ['transaction_date' => 'datetime'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(InventoryTransactionItem::class, 'transaction_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
