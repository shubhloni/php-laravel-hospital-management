@extends('layouts.app')

@section('content')
<a href="/TestProject/public/posts" class="btn">Go Back</a>
<h1>{{$post->title}}</h1>
<hr>
<div class="row">
  <div class="col-md-12">
    <img style="width:100%" src="/TestProject/public/storage/cover_images/{{$post->cover_image}}" alt="Cover">
  </div>
</div>
<hr>
<p>{{$post->body}}</p>
<hr>
    {{-- <a href="/TestProject/public/posts/{{$post->id}}/edit">Edit</a> --}}

    {{-- {!! Form::open(['action'=>['PostsController@destroy',$post->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
    {{Form::hidden('_method','DELETE')}}
    {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
    {!! Form::close() !!} --}}


@endsection
