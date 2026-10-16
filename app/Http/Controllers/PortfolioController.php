<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    /**
     * Display public portfolio SPA.
     */
    public function index()
    {
        $settingsRaw = ProfileSetting::all();
        $profile = [];
        foreach ($settingsRaw as $setting) {
            $val = json_decode($setting->value, true);
            $profile[$setting->key] = json_last_error() === JSON_ERROR_NONE ? $val : $setting->value;
        }

        $skills = Skill::orderBy('order')->orderBy('name')->get();
        $projects = Project::orderBy('order')->get();
        $experiences = Experience::orderBy('order')->get();

        return Inertia::render('Portfolio/Index', [
            'profile' => $profile,
            'skills' => $skills,
            'projects' => $projects,
            'experiences' => $experiences,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * Handle contact form submission.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:2500'],
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim dan akan segera saya balas.');
    }
}
