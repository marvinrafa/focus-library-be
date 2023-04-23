<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'year' => fake()->year(),
            'published' => fake()->boolean(),
            'author_id' => Author::all()->random()->id,
            'genre_id' => Genre::all()->random()->id
        ];
    }
}
