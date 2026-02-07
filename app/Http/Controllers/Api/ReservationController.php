<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Helpers\ResponseHelper;
use App\Services\ReservationService;

class ReservationController extends Controller
{

    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function create(StoreReservationRequest $request)
    {
        try {
            $book = Book::findOrFail($request->book_id);

            $reservation = $this->reservationService->createReservation(
                $request->user(),
                $book
            );
            return ResponseHelper::ok($reservation, 'Reservation created successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e);
        }
    }

    public function view()
    {
        try {
            $user = Auth::user();

            $reservations = $this->reservationService->viewReservation($user);

            return ResponseHelper::ok($reservations, 'Reservations fetched successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e);
        }
    }

    public function return(Reservation $reservation)
    {
        try {
            $reservation = $this->reservationService->returnBook($reservation);

            return ResponseHelper::ok($reservation, 'Book returned successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }
}
