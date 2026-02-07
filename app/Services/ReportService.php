<?php

namespace App\Services;

use App\Models\Reservation;
use App\Enums\ReservationStatus;

class ReportService
{

    public function getOverdueReservations()
    {
        $overdueReservations = Reservation::select(
            'id',
            'user_id',
            'book_id',
            'reserved_at',
            'due_date',
            'status',
            'fine_amount'
        )
            ->with([
                'user:id,name,email',
                'book:id,title,author,isbn',
            ])
            ->overdue()
            ->latest('due_date')
            ->get();

        return response()->json([
            'count' => $overdueReservations->count(),
            'data'  => $overdueReservations,
        ]);
    }
}
