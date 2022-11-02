<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function cant_get_all_books()
    {
        $books=Book::factory(4)->create();
        
        // mandamos a consultar los lobros insertados
    //    $this->get('/api/Books/')->dump();
   $response=  $this->getJson(route('Books.index'));

   $response->assertJsonFragment([
    'title'=>$books[0]->title
   ])
   ->assertJsonFragment([
    'title'=>$books[1]->title
   ]);

   
    }

     /** @test */
     public function cant_get_one_books()
     {
         $book=Book::factory()->create();
         
         //dd(route('Books.show', $book));    
         
      $this->getJson(route('Books.show', $book))->assertJsonFragment([
        'title'=>$book->title
        ]);
 
    
     }


      /** @test */
      public function cant_create_books()
      {
      
        $this->postJson(route('Books.store'),[])
        ->assertJsonValidationErrorFor('title');
          
        $this->postJson(route('Books.store'),[
            'title'=>'My new Book'
         ])->assertJsonFragment([
            'title'=>'My new Book'
            ]);
     
            $this->assertDatabaseHas('Books',[
                'title'=>'My new Book'     
            ]);
        
     
      }

      /** @test */
      public function cant_update_books()
      {
      
     
        $book=Book::factory()->create();

        $this->patchJson(route('Books.update',$book),[])
        ->assertJsonValidationErrorFor('title');
        

    $this->patchJson(route('Books.update',$book),[
            'title'=>'Edited Book'
     ])->assertJsonFragment([
        'title'=>'Edited Book'
        ]);

        $this->assertDatabaseHas('Books',[
            'title'=>'Edited Book'     
        ]);
      }


       /** @test */
       public function cant_delete_books()
       {
       
      
         $book=Book::factory()->create();

 
         $this->patchJson(route('Books.update',$book),[])
         ->assertJsonValidationErrorFor('title');
         
 
        $this->deleteJson(route('Books.destroy',$book))->assertNoContent();
 
         $this->assertDatabaseCount( 'Books',0);
       }
}
