<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class FineCalculationTest extends TestCase
{
    use RefreshDatabase;

    private ReservationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ReservationService();
    }

    public function test_no_fine_for_days_1_to_7()
    {
        $reservation = new Reservation([
            'due_date' => Carbon::now()->subDays(7),
        ]);

        $fine = $this->invokeCalculateFine($reservation);

        $this->assertEquals(0, $fine);
    }

    public function test_fine_is_calculated_for_days_8_to_14()
    {
        $reservation = new Reservation([
            'due_date' => Carbon::now()->subDays(10),
        ]);

        $fine = $this->invokeCalculateFine($reservation);

        $this->assertEquals(30, $fine);
    }

    public function test_fine_is_calculated_correctly_beyond_14_days()
    {
        $reservation = new Reservation([
            'due_date' => Carbon::now()->subDays(20),
        ]);

        $fine = $this->invokeCalculateFine($reservation);

        $this->assertEquals(190, $fine);
    }

    private function invokeCalculateFine(Reservation $reservation): float
    {
        $method = new \ReflectionMethod(
            ReservationService::class,
            'calculateFine'
        );

        return $method->invoke($this->service, $reservation);
    }
}
