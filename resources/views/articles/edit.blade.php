@extends('layouts.app');

@section("content");
    <div class="container">

        @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    {{ $error}}
                @endforeach
            </div>
        @endif

            <form action="{{ url("/articles/edit/$article->id") }}" method="post">
                @csrf
                <div class="mb-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $article->title }}">
                </div>
                <div class="mb-2">
                    <label for="">Body</label>
                    <textarea class ="form-control" type="text" name ="body">{{ $article->body }}</textarea>
                </div>
                <div class="mb-2">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-select">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if ($category->id == $article->category_id) selected
                                @endif >{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary">Update Article</button>
            </form>
    </div>
@endsection
