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
        else{
            $count = Rentlogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count();
            if($count >= 3){
                Session::flash('message', 'Cannot rent, user has a limit book!!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('rentlogs-add');     
            }
            else{
                RentLogs::create($request->all());
                $book = Book::findOrFail($request->book_id);
                $book->status = 'not avaliable';
                $book->save();
                Session::flash('message', 'Rent book succes');
                Session::flash('alert-class', 'alert-succcess');
                return redirect('rentlogs-add');     
            }
        }
    }

    public function edit()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = Book::all();
        return view ('admin.rent.returnlogs', ['users' => $users, 'books' => $books]);
    }

    public function update (Request $request)
    {
        $rent = Rentlogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)
        ->where('actual_return_date', null);

        $rentData = $rent->first();
        $rentCount = $rent->count();
        if($rentCount == 1){
            // return date masih nullll
            $rentData->actual_return_date = Carbon::now()->toDateString();
            $rentData->save();
            Session::flash('message', 'Renturn succesefully');
            Session::flash('alert-class', 'alert-succcess');
            return redirect('returnlogs'); 
        }
        else{
            // return date tidak nulll

        }
    }
}
