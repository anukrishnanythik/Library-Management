<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\ReservationService;
use App\Models\Book;
use App\Models\User;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(ReservationService $service): void
    {

        $members = User::where('role', 'member')->get();
        $books   = Book::where('available_copies', '>', 0)->get();

        foreach ($members as $member) {
            $book = $books->shift();

            if (! $book) {
                break;
            }

            $service->createReservation($member, $book);
        }
    }
}
