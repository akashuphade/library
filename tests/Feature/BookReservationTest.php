<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => "Five point someone",
            'author' => 'Chetan Bhagat'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {

        $response = $this->post('/books', [
            'title' => "",
            'author' => 'Chetan Bhagat'
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => "Five point someone",
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Five point someone',
            'author' => 'Chetan Bhagat'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'Three idiots',
            'author' => 'Unknown'
        ]);

        $this->assertEquals('Three idiots', Book::first()->title);
        $this->assertEquals('Unknown', Book::first()->author);
    }
}
