<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkinSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id', 'source', 'booking_id', 'status',
        'customer_name', 'started_at', 'completed_at',
        'total_price', 'created_by',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
        'total_price'  => 'decimal:2',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'walkin_session_service')
            ->withPivot('price')
            ->withTimestamps();
    }

    public function getServicesLabelAttribute(): string
    {
        return $this->services->pluck('name')->implode(', ');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeForBarber(Builder $query, $barberId): Builder
    {
        return ($barberId && $barberId !== 'all')
            ? $query->where('barber_id', $barberId)
            : $query;
    }

    public function scopeForDay(Builder $query, $date): Builder
    {
        return $query->whereDate('started_at', $date);
    }

    public function scopeForMonth(Builder $query, $year, $month): Builder
    {
        return $query->whereYear('started_at', $year)->whereMonth('started_at', $month);
    }

    public function scopeForYear(Builder $query, $year): Builder
    {
        return $query->whereYear('started_at', $year);
    }

    /**
     * Tạo (hoặc cập nhật) một bản ghi doanh thu từ lịch đặt trên web,
     * dùng khi admin bấm "Hoàn thành" cho một booking online.
     *
     * Gọi hàm này ngay trong action đánh dấu hoàn thành của
     * BookingController hiện có trong dự án, ví dụ:
     *
     *   $booking->update(['status' => 'completed']);
     *   WalkinSession::createFromBooking($booking);
     *
     * Điều chỉnh tên cột (service_id, appointment_at, customer_name...)
     * cho khớp với schema thật của bảng `bookings` trong dự án.
     */
    public static function createFromBooking(Booking $booking): self
    {
        $session = static::firstOrNew([
            'source'     => 'online',
            'booking_id' => $booking->id,
        ]);

        $session->barber_id     = $booking->barber_id;
        $session->customer_name = $booking->customer_name ?? $booking->name ?? null;
        $session->started_at    = $session->started_at ?? ($booking->appointment_at ?? now());
        $session->completed_at  = now();
        $session->status        = 'completed';
        $session->save();

        if ($booking->service_id) {
            $price = optional($booking->service)->price ?? $booking->price ?? 0;

            $session->services()->sync([
                $booking->service_id => ['price' => $price],
            ]);

            $session->total_price = $price;
            $session->save();
        }

        return $session;
    }
}
