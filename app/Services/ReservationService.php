<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReservationService
{
public function createReservation(User $user, Book $book): Reservation
    {
        return DB::transaction(function () use ($user, $book) {
            $book = Book::where('id', $book->id)->lockForUpdate()->first();

            $reservation = Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);

            $book->decrement('available_copies');

            return $reservation;
        });
    }

    public function viewReservation($user)
    {
        return Reservation::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }
}
