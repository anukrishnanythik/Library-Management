<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class CanReserveBook implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
         $user = Auth::user();

        if (! $user) {
            $fail('Unauthorized.');
            return;
        }

         $activeReservations = Reservation::where('user_id', $user->id)
            ->where('status', ReservationStatus::ACTIVE)
            ->count();

        if ($activeReservations >= 3) {
            $fail('You cannot have more than 3 active reservations.');
            return;
        }

        $book = Book::find($value);

        if (! $book || $book->available_copies <= 0) {
            $fail('This book is currently unavailable.');
        }
    }
}


