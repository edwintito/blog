@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <a href="{{route('posts.create')}}" class="btn btn-success">Create Post</a>
                    <h3>Your Posts</h3>
                        @if(count($posts) > 0)
                            <table class="table table-striped">
                                <tr>
                                    <th colspan="5">Title</th>
                                </tr>
                        @foreach($posts as $post)
                                <tr>
                                    <td>{{$post ->title}}</td>
                                    <td colspan="2"><a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a></td>
                                    <td>
                                        <form action="{{route('posts.destroy',$post -> id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        @else
                            <p>You Have No Posts</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
