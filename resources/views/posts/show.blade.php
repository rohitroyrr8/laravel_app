
@extends('layouts.app')

@section('content')
        
        <h3>{{$post->title}}</h3>
        <img src="http://localhost/laravel_app/public/storage/cover_images/{{$post->cover_image}}" style="width: 100%">
        <br><br>
        <strong>Written On: {{$post->created_at}}</strong><br><br>
        <div>
           {!!$post->body!!}

        </div>
        <hr>
        
        <!--  condional statements for displaying/hiding buttons -->
        @if(!Auth::guest())
                @if(Auth::user()->id  == $post->user_id)
                        {!! Form::open([ 'action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('DELETE', ['class' => 'btn btn-danger pull-right'])}}
                        {!!Form:: close()!!}
                        <a href="{{$post->id}}/edit" class="btn btn-default">Edit Post</a>
                @endif  
       
        @endif
        
@endsection