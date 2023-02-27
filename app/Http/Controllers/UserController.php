<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile');
    }

    public function book(Request $request)
    {
        $books = Book::all();
        $categories = Category::all();
        if($request->category || $request->title){
            $books = Book::where('title','like', '%'.$request->title.'%')->orwhereHas('categories', function($q) use($request){
                $q->where('categories.id', $request->category);
            })->get();
        }
        else{
            $books = Book::all();
        }

        return view('user.book', ['books' => $books, 'categories' => $categories]);
    }
}
