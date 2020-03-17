@extends('layouts.master')

@section('content')

    <a href="/posts" class="btn btn-primary">Back</a>
    <h1>{{$post->title}}</h1>
    <img width="50%" src="/storage/cover_images/{{$post->cover_image}}" >
    <div>
        {{$post ->body}}
    </div>
    <hr>
    <small>Posted On {{$post -> created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
        <a href="/posts/{{$post -> id}}/edit" class="btn btn-success" style="float: left;">Edit</a>
        <form action="{{route('posts.destroy',$post -> id)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger"style="float: right;">Delete</button>
        </form>
        @endif
    @endif
    @endsection
