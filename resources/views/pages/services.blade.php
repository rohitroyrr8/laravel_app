@extends('layouts.app')
@section('content')
        <h1>Our Services</h1>
        @if(count($services)>0)
             <ul>
                 @foreach($services as $service)
                      <li>{{$service}}</li>
                 @endforeach
             </ul>
        @endif
@endsection
