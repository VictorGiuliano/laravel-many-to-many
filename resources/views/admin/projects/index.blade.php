@extends ('layouts.app')
@section ('title','Projects')
    
@section ('content')
<h1>Projects</h1>
<div class=" bkg-b">
    <div class="card-container">
        @foreach ($projects as $project)
          <div class="project-card">
            <img class="img-fluid" src='{{asset('storage/' . $project['image'])}}' alt="{{$project->title}}">
            <h4>Title: {{$project->title}}</h4>
            <div class="container d-flex justify-content-center">
                <a href="{{route('admin.projects.show', $project->id)}}" class="btn mx-3 small btn-primary"><i class="fa-solid fa-eye"></i></a>
                <form action="{{route('admin.projects.destroy',$project->id)}}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                <button type="submit" class="btn small btn-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>  
        @endforeach
    </div>
</div>
@endsection
