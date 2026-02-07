<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
     protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:20'],
        ]);

        try {
            $data = $this->authService->login($request->email, $request->password);

            return ResponseHelper::ok($data, 'Login successful');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request->user());

            return ResponseHelper::ok(null, 'Logged out successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }
}
