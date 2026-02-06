<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    /**
     * Search for books by query string
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(string $query)
    {
        return Book::where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%")
                ->orWhere('isbn', 'LIKE', "%{$query}%");
        })
            ->available()
            ->get();
    }
}
