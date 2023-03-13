
<div class="form-create mt-5 bg-light p-5 rounded-3">
@if($project->exists)
<form method="POST" novalidate action="{{ route('admin.projects.update', $project->id)}}" enctype="multipart/form-data">
    @method('PUT')
@else
<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
@endif
        @csrf
        <div class="row">
            
            {{-- Titolo --}}
            <div class="col-6">
                <div class="mb-3 ">
                    <label for="title" class="form-label d-block">Title:</label>
                    <input type="text" class="form-control" id="title" minlength="2" maxlength="100" placeholder="Inserisci il titolo" value="{{old('title', $project->title)}}"
                        name="title" required>
                </div>
            </div>
            {{-- Link github --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="github" class="form-label">Link Project:</label>
                    <input type="url" class="form-control" id="github"
                        placeholder="Inserisci url github" value="{{old('github',$project->github)}}" name="github">
                </div>
            </div>
            {{-- Image --}}
            <div class="col-6">
                <div class="mb-3">
                    <label for="img" class="form-label">Image:</label>
                    <input type="file" class="form-control" id="image"
                        placeholder="Inserisci url image" value="{{old('image',$project->image)}}" name="image">
                </div>
            </div>
            <div class="col-1">
                    <img id="preview" class="img-fluid" src="{{$project->image ? asset('storage/'. $project->image) : 'https://marcolanci.it/utils/placeholder.jpg'}}" alt="">
            </div>
            {{-- Type --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="type_id" class="form-label">Type:</label>
                    <select class="form-select" name="type_id" id="type_id">
                        <option value="">-</option>
                        @foreach ($types as $type)
                        <option @if($project->type_id == $type->id) selected @endif value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Tech --}}
            <div class="col-8">
                <div class="mb-3">
                    <h3>Tech</h3>
                    @foreach($technologies as $technology)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="tech-{{$technology->id}}" value="{{$technology->id}}" name="techs[]"
                        @if(in_array($technology->id, old('technologies', []))) checked @endif>
                        <label class="form-check-label" for="tech-{{$technology->id}}">{{$technology->name}}</label>
                    </div>    
                    @endforeach
                    @error('technologies')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
            {{-- Description --}}
            <div class="col-12">
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea type="text" class="form-control" id="description"
                        placeholder="Inserisci descrizione" name="description">{{old('description',$project->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end p-5">
            <button type="submit" class="btn px-5 border-white btn-primary">Salva</button>
        </div>
        <a href="{{ route('admin.home') }}" class="btn mx-1 small btn-secondary">Indietro</a>
    </form>
</div>
