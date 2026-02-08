<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use LogicException;
use App\Enums\ReservationStatus;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'reserved_at',
        'due_date',
        'returned_at',
        'status',
        'fine_amount',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
        'fine_amount' => 'decimal:2',
        'status' => ReservationStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getOverdueDaysAttribute(): int
    {
        $days = now()->startOfDay()
            ->diffInDays($this->due_date->startOfDay(), false);
             return max(0, -$days);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ReservationStatus::ACTIVE);
    }

    public function scopeReturned(Builder $query): Builder
    {
        return $query->where('status', ReservationStatus::RETURNED);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', ReservationStatus::OVERDUE);
    }

    protected static function booted()
    {
        static::creating(function (Reservation $reservation) {

            $reservation->due_date = Carbon::parse($reservation->reserved_at)->addDays(14);

            if (is_null($reservation->status)) {
                $reservation->status = ReservationStatus::ACTIVE;
            }

            if ($reservation->fine_amount < 0) {
                throw new LogicException('Fine amount cannot be negative');
            }
        });

        static::updating(function (Reservation $reservation) {

            if ($reservation->due_date < $reservation->reserved_at) {
                throw new LogicException('Due date cannot be before reserved date');
            }

            if (
                $reservation->status === ReservationStatus::ACTIVE &&
                $reservation->due_date->isPast() &&
                is_null($reservation->returned_at)
            ) {
                $reservation->status = ReservationStatus::OVERDUE;
            }
        });
    }
}

