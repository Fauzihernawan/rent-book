@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<h3>Hai, {{Auth::user()->username}}</h3>
  <!-- Table Rent Logs -->
  <div class="mt-4">
        <table class="table" style="background-color: #ECF9FF">
            <thead>
                <tr>
                <th>No</th>
                <th>Book code</th> 
                <th>Book Title</th>
                <th>Rent Date</th>
                <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentlogs as $value)
                <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->book->book_code}}</td>
                <td>{{$value->book->title}}</td>
                <td>{{$value->rent_date}}</td>
                <td>{{$value->return_date}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- EndTable -->

@endsection