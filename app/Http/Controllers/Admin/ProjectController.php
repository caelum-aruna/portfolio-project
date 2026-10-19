<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('order')->orderByDesc('id')->get();

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'details' => ['nullable', 'string'],
            'tech_stack' => ['nullable'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'repo_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['boolean'],
            'order' => ['integer'],
            'thumbnail' => ['nullable'],
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('projects', 'public');
            $validated['thumbnail'] = '/storage/'.$path;
        }

        if (is_string($validated['tech_stack'] ?? null)) {
            $validated['tech_stack'] = array_filter(array_map('trim', explode(',', $validated['tech_stack'])));
        }

        $validated['slug'] = Str::slug($validated['title']).'-'.time();

        Project::create($validated);

        return back()->with('success', 'Project berhasil ditambahkan.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'details' => ['nullable', 'string'],
            'tech_stack' => ['nullable'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'repo_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['boolean'],
            'order' => ['integer'],
            'thumbnail' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('projects', 'public');
            $validated['thumbnail'] = '/storage/'.$path;
        }

        if (is_string($validated['tech_stack'] ?? null)) {
            $validated['tech_stack'] = array_filter(array_map('trim', explode(',', $validated['tech_stack'])));
        }

        $project->update($validated);

        return back()->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'Project berhasil dihapus.');
    }
}
