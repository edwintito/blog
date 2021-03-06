@extends('layouts.master')

@section('content')
    <h1>Posts</h1>
    <p class="alert alert-success">{{session('msg')}}</p>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="jumbotron">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img width="100%" src="/storage/cover_images/{{$post->cover_image}}" >
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post -> title}}</a></h3>
                        <small>Posted On {{$post ->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
            </div>
            @endforeach
        {{$posts -> links()}}
    @else
        <p>No Posts Available</p>
    @endif
    @endsection
