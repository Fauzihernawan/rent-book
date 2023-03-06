<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Rentlogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class RentlogController extends Controller
{
    public function Add()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = Book::all();
        return view('admin.rent.add', ['users' => $users, 'books' => $books]);
    }

    public function Store(Request $request)
    {
        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();
        $book = Book::findOrFail($request->book_id)->only('status');

        // cek status buku
        if($book['status'] != 'stok'){
            // kalo buku statusnya bukan in stok
            Session::flash('message', 'Cannot rent, book is no available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('rentlogs-add');
        }
        RentLogs::create($request->all());
    }
}