@extends('layouts.master')

@section('content')
    <h1>Create A Post</h1>
    <form action="/posts" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Post Title">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea  class="form-control" id= article-ckeditor rows="5" name="body" id="body" placeholder="Post Body"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Create Post">
        </div>
    </form>
    @endsection
