<?php

namespace App\Services;

use App\Models\Book;

class BookService
{

    public function search(string $query)
    {
        return Book::select([
            'uuid',
            'title',
            'author',
            'isbn',
            'category',
            'total_copies',
            'available_copies'
            ])
            ->where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%")
                ->orWhere('isbn', 'LIKE', "%{$query}%");
        })
            ->available()
            ->orderBy('title')
            ->get();
    }

    public function createBook(array $data): Book
    {
        return Book::create($data);
    }

    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book->fresh();
    }

    public function deleteBook(Book $book): bool
    {
        return (bool) $book->delete();
    }
}


