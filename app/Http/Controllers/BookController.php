<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  return [];
       return Book::all();
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'=>['required']
        ]);


        $book =new Book;
        $book->title=$request->title;
        $book->save();

        return $book;

    }


    public function show( $book)
    {
        return Book::find($book) ;
    }

   
    public function update(Request $request,  $book)
    {
       // return Book::find($book) ;

        $request->validate([
            'title'=>['required']
        ]);

        
        $book = Book::find($book) ;
        $book->title=$request->title;
        $book->save();

        return $book;
    }

   
    public function destroy( $book)
    {
        $book = Book::find($book) ;
        
        $book->delete();
        return response()->noContent();

    }
}
