<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => str()->uuid(),
            'title' => fake()->words(3, true),
            'author' => fake()->name(),
            'isbn'   => fake()->unique()->isbn13(),
            'total_copies' => fake()->numberBetween(1, 10),
            'available_copies' => function (array $attributes) {
                return $attributes['total_copies'];
            },
            'category' => fake()->randomElement(['Fiction', 'Science', 'History', 'Biography', 'Technology']),
        ];
    }
}
