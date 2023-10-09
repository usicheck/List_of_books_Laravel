<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;


class AuthorBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Author::factory(15)->create();

        $books = Book::factory(50)->create();

        foreach ($books as $book) {
            $imagePath = 'storage/images/example.png';
            $book->update(['image' => $imagePath]);

            $authors = Author::inRandomOrder()->limit(rand(1, 5))->get();
            $book->authors()->attach($authors);
        }
    }


}
