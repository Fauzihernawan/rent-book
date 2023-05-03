<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Rentlogs;
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
         return view('admin.category.index',['category' => $category]);
     }
    public function categoryAdd()
     {
         return view('admin.category.add');
     }
    public function categoryStore(Request $request)
     { 
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
         return view('admin.category.edit', ['category' => $category]);
     } 
    public function categoryUpdate(Request $request, $slug)
     { 
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

    public function books()
     {
         $book = Book::all();
         return view('admin.book.index', ['book' => $book]);     
     }
    public function booksAdd()
     {
         $categories = Category::all();
         return view('admin.book.add',['categories' => $categories]);
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
   public function bookEdit($slug)
     {
         $books= Book::where('slug', $slug)->first();
         $categories = Category::all();
         return view('admin.book.edit', ['books' => $books, 'categories' => $categories]);
     }
   public function bookUpdate(Request $request, $slug)
    {
      if($request->file('image')){
         $extension = $request->file('image')->getClientOriginalExtension();
         $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
         $request->file('image')->storeAs('cover',$newName);
         $request['cover'] = $newName;
         }         
         $book = Book::where('slug', $slug)->first();
         $book->update($request->all());
         if($request->categories){
         $book->categories()->sync($request->categories);
         }
         return redirect('book')->with('status', 'Books Updated Successfully');
    }
   public function bookDestroy($slug)
    {
         $book =  Book::where('slug', $slug)->first();
         $book->delete();
         return redirect('book')->with('status', 'Book Deleted Successfully');
    }

   public function users()
    {
         $users = User::where('roles_id', 2)->where('status', 'active')->get();
         return view('admin.user.user', ['users' => $users]);
    }

    public function usersRegistered()
     {
         $usersRegistered = User::where('roles_id', 2)->where('status', 'inactive')->get();
         return view('admin.user.user-registered', ['usersRegistered' => $usersRegistered]);
     }

     public function usersDetail($slug)
     {
         $user = User::where('slug', $slug)->first();
         return view ('admin.user.user-detail', ['user' => $user]);
     }

     public function usersApprove($slug)
     {
         $user = User::where('slug', $slug)->first();
         $user->status = 'active';
         $user->save();
         return redirect('users-detail/'.$slug)->with('status', 'User approved successfully');
     }

     public function usersBan($slug)
     {
      $user = User::where('slug', $slug)->first();
      $user->delete();
      return redirect('users')->with('status', 'User deleted successfully');
     }

     public function usersBanned()
     {
       $usersBanned = User::onlyTrashed()->get();
       return view ('admin.user.user-banned', ['usersBanned' => $usersBanned]);
     }

     public function usersRestore($slug)
     {
      $user = User::withTrashed()->where('slug', $slug)->first();
      $user->restore();
      return redirect('users')->with('status', 'User restored successfully');
     }
   
   public function rentlogs()
         {
            $rentlogs = Rentlogs::with(['user', 'book' ])->get();
            return view('admin.rent.rentlog', ['rentlogs' => $rentlogs]);
         }
    
    
   }