<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getIsMemberAttribute(): bool
    {
        return $this->role === 'member';
    }

    public function getIsLibrarianAttribute(): bool
    {
        return $this->role === 'librarian';
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    public function scopeLibrarians($query)
    {
        return $query->where('role', 'librarian');
    }
}
