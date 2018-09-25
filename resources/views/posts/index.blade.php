@extends('layouts.app')

@section('content')
        <h3>Posts</h3>
        @if(count($posts) > 0)
                @foreach($posts as $post)
                        <div class="well">
                                <div class="row">
                                        <div class="col-md-4">
                                        <img src="../public/storage/cover_images/{{$post->cover_image}}" style="width: 100%">
                                        </div>
                                        <div class="col-md-8">
                                        <h3><a href="posts/{{$post->id}}">{{$post->title}}</a></h3>
                                        <small>Published On: {{$post->created_at}}</small>
                                        </div>
                                </div>
                        
                        </div>
                @endforeach
                {{$posts->links()}}
        @else
                <p>Sorry, No Posts Found.</p>
        @endif
@endsection