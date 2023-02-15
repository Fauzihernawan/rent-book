@extends('layouts.main')

@section('title', 'Edit Category')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<h1>Edit Book</h1>
@if ($errors->any())
        <div class=" alert alert-danger w-50">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="" method="post">
    @csrf
    @method('put')
   <label for="book_code" class="mb-2 mt-3 form-label">Book Code</label>
   <input type="book_code" name="book_code" id="book_code" class="w-50 form-control" value="{{$books->book_code}}"placeholder="Book code">
   <label for="title" class="mb-2 mt-3 form-label">Title</label>
   <input type="title" name="title" id="title" class="w-50 form-control" value="{{$books->title}}" placeholder="Title">
   <label for="cover" class="mb-2 mt-3 form-label">Cover</label>
   <input type="file" name="image" id="image" class="mt-4 mb-2 w-50 form-control">
   <div class="mb-3">
   <label for="currentCover" class="form-label d-block">currentCover</label>
        @if($books->cover != '')
         <img src="{{asset('storage/cover/'.$books->cover)}}" alt="" width="75px" height="85 px">
        @else
         <img src="{{asset('assets/img/notfound.jpg')}}" alt="" width="75px">
        @endif 
    </div>
   <label for="categories" class=" form-label">Category</label> <br>
   <select name="categories[]" id="categories" class="w-50 form-control select" multiple="multiple">
            @foreach($categories as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
   </select>
   <div class="mb-3">
   <label for="listcategory" class="form-label mt-3">Current Category</label>
   <ul>
      @foreach($books->categories as $category)
      <li>{{$category->name}}</li>
      @endforeach
   </ul>
   </div>
   <button type="submit" class="btn btn-success">Update</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
        $('.select').select2();
        });
    </script>
</form>
@endsection