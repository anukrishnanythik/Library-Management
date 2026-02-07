<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'uuid'             => $this->uuid,
            'title'            => $this->title,
            'author'           => $this->author,
            'isbn'             => $this->isbn,
            'category'         => $this->category,
            'total_copies'     => $this->total_copies,
            'available_copies' => $this->available_copies,
            'is_available'     => $this->is_available,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }
}
