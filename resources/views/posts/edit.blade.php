
@extends('layouts.app')

@section('content')
        <h3>Edit Post</h3>
        {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST' , 'enctype' => 'multipart/form-data' ]) !!}
        <div class="form-group mt-20">
            {{Form::label('title','Enter you Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Give you post suitable title'])}}
        </div>
        <div class="form-group mt-20">
            {{Form::label('body','Describe your post')}}
            {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Post Body'])}}
        </div>
          <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{ Form::hidden('_method', 'PUT') }}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
@endsection