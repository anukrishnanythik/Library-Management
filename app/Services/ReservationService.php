<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Enums\ReservationStatus;

class ReservationService
{
    public function createReservation(User $user, Book $book): Reservation
    {
        return DB::transaction(function () use ($user, $book) {
            $book = Book::where('id', $book->id)->lockForUpdate()->first();

            $reservation = Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'reserved_at' => now(),
                'due_date'    => now()->addDays(7),
                'status'      => ReservationStatus::ACTIVE,
                'fine_amount' => 0,
            ]);

            $book->decrement('available_copies');

            return $reservation;
        });
    }

    public function viewReservation($user)
    {
        return Reservation::select('id', 'user_id', 'book_id', 'reserved_at', 'due_date', 'status', 'fine_amount')
            ->with('book:id,title,author,isbn,available_copies')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }
}
