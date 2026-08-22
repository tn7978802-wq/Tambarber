<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'service_id',
        'barber_id',
        'booking_date',
        'booking_time',
        'note',
        'status',   // pending | confirmed | completed | cancelled
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed']);
    }
}