<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('project', 'technologies', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:projects|min:2|max:100',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg, jpg, png',
            'github' => 'nullable|url',
            'types_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
        ], [
            'title.required' => 'Il titolo è necessario',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.unique' => 'Il titolo non può essere lo stesso di un altro progetto',
            'title.min' => 'Il titolo è necessario sia di almeno 2 lettere',
            'title.max' => 'Il titolo è necessario sia meno di almeno 100 lettere',
            'description.required' => 'Il paragrafo deve essere inserito',
            'description.string' => 'Il paragraph deve essere una stringa',
            'image.image' => 'L\' immagine deve essere un file immagine',
            'image.mimes' => 'L\' immagine deve avere come estensioni jpeg, jpg, png',
            'github.url' => 'Il link github deve essere corretto',
            'type_id' => 'Tipo non valido',
            'technologies' => 'Le technologies selezionate non sono valide.'

        ]);
        $data = $request->all();
        $project = new Project();
        if (array_key_exists('image', $data)) {
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;
        }
        $project->fill($data);

        $project->slug = Str::slug($project->title, '-');
        $project->save();

        if (Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);
        //$project->technologies()->attach($data['technologies']);
        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('msg', "Il project '$project->title' è stato creato con successo.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        $project_technologies = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'technologies', 'types', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => ['required', 'string', Rule::unique('projects')->ignore($project->id), 'min:2', 'max:100'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image|mimes:jpeg, jpg, png'],
            'github' => ['nullable', 'url'],
            'techs' => 'nullable|exists:tech,id'

        ], [
            'title.required' => 'Il titolo è necessario',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.unique' => 'Il titolo non può essere lo stesso di un altro progetto',
            'title.min' => 'Il titolo è necessario sia di almeno 2 lettere',
            'title.max' => 'Il titolo è necessario sia meno di almeno 100 lettere',
            'description.required' => 'La descrizione deve essere inserita',
            'description.string' => 'La descrizione deve essere una stringa',
            'image.image' => 'L\' immagine deve essere un file immagine',
            'image.mimes' => 'L\' immagine deve avere come estensioni jpeg, jpg, png',
            'github.url' => 'Il link github deve essere corretto',
            'techs' => 'Le tech selezionati non sono validi.'

        ]);
        $data = $request->all();
        $project['slug'] = Str::slug($data['title'], '-');
        if (array_key_exists('image', $data)) {
            if ($project->image) Storage::delete($project->image);
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;
        }

        $project->update($data);
        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else $project->technologies()->detach();
        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('msg', "Il project '$project->title' è stato aggiornato con successo.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) Storage::delete($project->image);
        if (count($project->technologies)) $project->technologies()->detach();
        $project->delete();
        return to_route('admin.projects.index')->with('type', 'danger')->with('msg', "Il project '$project->title' è stato cancellato con successo.");
    }
}
