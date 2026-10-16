<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'total_skills' => Skill::count(),
            'total_experiences' => Experience::count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recent_messages = ContactMessage::latest()->take(5)->get();
        $recent_projects = Project::orderBy('order')->take(4)->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_messages' => $recent_messages,
            'recent_projects' => $recent_projects,
        ]);
    }
}
