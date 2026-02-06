<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

    class ResponseHelper
{

    public static function incorrectValues($e = null, string $message = 'An error occurred while processing your request,Please try again.')
    {
        Log::error($e);
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e ?? 'Undefined error',
        ], 422);
    }

    public static function notFound($e = null, string $message = 'Page Not Found')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e,
        ], 404);
    }

    public static function ok($data = null, $message = null)
    {
        $responseData = [
            'success' => true,
            'data' => $data
        ];
        if ($message !== null) {
            $responseData['message'] = $message;
        }
        return response()->json($responseData, 200);
    }

    public static function internalServerError($e = null, string $message = 'Internal Server Error')
    {
        Log::error($e);
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e,
        ], 500);
    }
}
