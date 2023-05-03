@extends('layouts.main')

@section('title', ' Return Book')

@section('content')
<div class="py-5">
    <div class="text-center">
        <h2>Return Book</h2>
    </div>
</div>
<div class="col-12 col-md-8 offset-md-2 col-md-4 offset-md-4">
    <div class="mt-4">
        @if(session('message'))
            <div class="w-50 alert {{session('alert-class')}}">
                {{session('message')}}
            </div>
        @endif
    </div>
    <form action="/returnlogs" method="post">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="w-50 form-control">
            <option value="">Select User</option>
            @foreach($users as $item)
                <option value="{{$item->id}}">{{$item->username}}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="book_id" class="form-label">Book</label>
            <select name="book_id" id="book_id" class="w-50 form-control">
            <option value="">Select Book</option>
            @foreach($books as $item)
                <option value="{{$item->id}}">{{$item->title}}</option>
            @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection