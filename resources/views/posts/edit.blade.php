@extends('layouts.master')

@section('content')
    <h1>Edit A Post</h1>
    <form action="/posts/{{$post->id}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Post Title" value="{{$post->title}}">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea  class="form-control" id= article-ckeditor rows="5" name="body" id="body" value="">{{$post ->body}}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Edit Post">
        </div>
    </form>
@endsection
