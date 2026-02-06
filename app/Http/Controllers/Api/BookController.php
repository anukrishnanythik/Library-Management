<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\ResponseHelper;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        try {
            $books = $this->bookService->search($request->query('query'));

            return ResponseHelper::ok($books, 'Books fetched successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e);
        }
    }
}
