<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('order')->get();
        return Inertia::render('Admin/Skills/Index', [
            'skills' => $skills,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
            'proficiency' => ['required', 'integer', 'min:0', 'max:100'],
            'order' => ['integer'],
        ]);

        Skill::create($validated);

        return back()->with('success', 'Skill berhasil ditambahkan.');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
            'proficiency' => ['required', 'integer', 'min:0', 'max:100'],
            'order' => ['integer'],
        ]);

        $skill->update($validated);

        return back()->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill berhasil dihapus.');
    }
}
