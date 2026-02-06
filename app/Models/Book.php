<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use LogicException;

class Book extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    protected $fillable = [
        'uuid',
        'title',
        'author',
        'isbn',
        'total_copies',
        'available_copies',
        'category',
    ];

     protected $casts = [
        'total_copies'     => 'integer',
        'available_copies' => 'integer',
    ];

      protected $hidden = [
        'deleted_at',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

     public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function activeReservations()
    {
        return $this->hasMany(Reservation::class)
            ->where('status', \App\Enums\ReservationStatus::ACTIVE);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available_copies', '>', 0);
    }

    //  Accessors
     public function getIsAvailableAttribute(): bool
    {
        return $this->available_copies > 0;
    }

    protected static function booted()
    {
        static::creating(function ($book) {
            if ($book->available_copies > $book->total_copies) {
                $book->available_copies = $book->total_copies;
            }
        });

        static::updating(function ($book) {
            if ($book->available_copies > $book->total_copies) {
                throw new LogicException(
                    'Available copies cannot exceed total copies'
                );
            }
        });
    }
}
