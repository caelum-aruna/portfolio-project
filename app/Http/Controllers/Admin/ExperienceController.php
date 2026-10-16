<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('order')->orderByDesc('id')->get();
        return Inertia::render('Admin/Experiences/Index', [
            'experiences' => $experiences,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => ['required', 'string', 'max:150'],
            'company' => ['required', 'string', 'max:150'],
            'period' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:work,education,organization'],
            'order' => ['integer'],
        ]);

        Experience::create($validated);

        return back()->with('success', 'Pengalaman berhasil ditambahkan.');
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'position' => ['required', 'string', 'max:150'],
            'company' => ['required', 'string', 'max:150'],
            'period' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:work,education,organization'],
            'order' => ['integer'],
        ]);

        $experience->update($validated);

        return back()->with('success', 'Pengalaman berhasil diperbarui.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Pengalaman berhasil dihapus.');
    }
}
