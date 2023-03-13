@extends('layouts.app')
@section('title',$project->title)

@section('content')
<header>
    <div class="container d-flex justify-content-start my-3">
        <a href="{{route('admin.projects.index') }}" class="btn mx-1  btn-secondary">Indietro</a>
    </div>
    <h1>{{$project->title}}</h1> 
</header>
<div class="clearfix">
@if($project->image)
<img class="mx-2 float-start img-fluid "src='{{asset('storage/' . $project['image'])}}' alt="{{$project->title}}">
@endif
<p>{{$project->description}}</p>
<div><time><strong>Creato il: </strong>{{$project->created_at}}</time></div>
<div><time><strong>Ultima modifica il:</strong> {{$project->updated_at}}</time></div>
<div><strong>Type:</strong> {{$project->type?->name}}</div>
<hr>
<div class="container d-flex pt-3 justify-content-start">
    <a href="{{$project->github}}" class="btn mx-1 sm btn-primary">Vai al sito <i class="fa-brands fa-github"></i></a>
    <a href="{{route('admin.projects.edit', $project->id)}}" class="btn btn-warning">Modifica</a>
</div>
</div>
@endsection