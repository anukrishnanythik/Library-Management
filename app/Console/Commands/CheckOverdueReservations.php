<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class CheckOverdueReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Mark reservations as overdue when due date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updated = Reservation::where('status', ReservationStatus::ACTIVE)
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->update([
                'status' => ReservationStatus::OVERDUE
            ]);
        Log::info("Marked {$updated} reservations as overdue.");
    }
}
