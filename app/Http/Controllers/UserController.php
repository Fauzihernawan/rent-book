<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rentlogs;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $rentlogs = Rentlogs::with(['user', 'book'])->where('user_id', Auth::user()->id)->get();
        return view('user.profile', ['rentlogs' => $rentlogs]);
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
