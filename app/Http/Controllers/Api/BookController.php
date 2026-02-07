<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\BookService;
use App\Models\Book;
use Exception;
use App\Helpers\ResponseHelper;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $book = $this->bookService->createBook($request->validated());

            return ResponseHelper::ok(new BookResource($book), 'Book created successfully', 201);
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $book = $this->bookService->updateBook($book, $request->validated());

            return ResponseHelper::ok(new BookResource($book), 'Book updated successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        try {
            $this->bookService->deleteBook($book);

            return ResponseHelper::ok(null, 'Book deleted successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }

    public function search(string $query)
    {
        try {
            $books = $this->bookService->search($query);

            return ResponseHelper::ok(BookResource::collection($books), 'Books fetched successfully');
        } catch (Exception $e) {
            return ResponseHelper::incorrectValues($e->getMessage());
        }
    }
}
