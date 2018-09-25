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
                    <a href="posts/create" class="btn btn-primary">Create New Post</a>
                    <h3>Your Blog Posts</h3>
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{$post->title}}</td>
                            <td><a href="/posts/{{$post->id}}/edit">Edit</a></td>
                            <td>
                                {!! Form::open([ 'action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('DELETE', ['class' => 'btn btn-danger pull-right'])}}
                                {!!Form:: close()!!}
                            </td>
                        </tr>    
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
