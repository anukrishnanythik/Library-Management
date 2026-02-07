<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Helpers\ResponseHelper;
use Exception;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function overdue()
    {
        try {
            $overdueReservations = $this->reportService->getOverdueReservations();

            return ResponseHelper::ok($overdueReservations, 'Overdue reservations fetched successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }
}
