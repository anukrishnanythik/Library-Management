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


    private function calculateFine(Reservation $reservation): float
    {
        if (now()->lessThanOrEqualTo($reservation->due_date)) {
            return 0;
        }

        $daysOverdue = now()->diffInDays($reservation->due_date);

        if ($daysOverdue <= 7) {
            return 0;
        }

        $fine = 0;

        if ($daysOverdue <= 14) {
            $fine = ($daysOverdue - 7) * 10;
        } else {
            $fine = (7 * 10) + (($daysOverdue - 14) * 20);
        }

        return (float) $fine;
    }

    public function returnBook(Reservation $reservation): Reservation
    {
        return DB::transaction(function () use ($reservation) {
            if ($reservation->status === ReservationStatus::RETURNED) {
                return $reservation();
            }

            $fineAmount = $this->calculateFine($reservation);

            $book = Book::where('id', $reservation->book_id)->lockForUpdate()->first();

            if ($book->available_copies < $book->total_copies) {
                $book->increment('available_copies');
            } else {
                $book->available_copies = $book->total_copies;
                $book->save();
            }

            $reservation->update([
                'status' => ReservationStatus::RETURNED,
                'returned_at' => now(),
                'fine_amount' => $fineAmount,
            ]);

            return $reservation;
        });
    }
}
