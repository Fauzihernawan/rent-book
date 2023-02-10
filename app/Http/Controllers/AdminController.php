<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $bookCount = Book::count();
        $categoryCount = Category::count();
        $userCount = User::count();
        return view('admin.dashboard', ['book_count' => $bookCount, 'category_count' => $categoryCount, 'user_count' => $userCount]);
    }
    public function categorys()
    {
       $category = Category::all();
       return view('admin.category',['category' => $category]);
    }
    public function users()
    {
       return view('admin.user');
    }


    public function books()
    {
       $book = Book::all();
       return view('admin.book', ['book' => $book]);

    }

    public function booksAdd()
    {
      $categories = Category::all();
      return view('admin.book-add',['categories' => $categories]);
    }

    public function booksStore(Request $request)
    {
         $validated = $request->validate([
               'book_code' => 'required|unique:books',
               'title' => 'required',
         ]);

         $newName = '';
         if($request->file('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
            $request->file('image')->storeAs('cover',$newName);
         }

         $request['cover'] = $newName;
         $book = Book::create($request->all());
         $book->categories()->sync($request->categories);
         return redirect('book')->with('status', 'Book Added Successfully');
    }

    public function rentlogs()
    {
       return view('admin.rentlog');
    }

    public function categoryAdd()
    {
      return view('admin.categoryadd');
    }

    public function categoryStore(Request $request)
    {
      // 
      $validated = $request->validate([
         'name' => 'required|unique:categories',
     ]);

      // memaksukan data ke database
      $category = Category::create($request->all());
      return redirect('category')->with('status', 'Category Added Successfully');
    }

    public function categoryEdit($slug)
    {
      $category = Category::where('slug', $slug)->first();
      return view('admin.category-edit', ['category' => $category]);
    }
    
    public function categoryUpdate(Request $request, $slug)
    {
         // 
         $validated = $request->validate([
            'name' => 'required|unique:categories',
      ]);
      $category = Category::where('slug', $slug)->first();
      $category->slug = null;
      $category->update($request->all());
      return redirect('category')->with('status', 'Category Updated Successfully');
    }

    public function categoryDestroy($slug)
    {
      $category = Category::where('slug', $slug)->first();
      $category->delete();
      return redirect('category')->with('status', 'Category Deleted Successfully');
    }

}