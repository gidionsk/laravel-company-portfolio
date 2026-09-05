<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'projects' => Project::count(),
            'published' => Project::where('is_published', true)->count(),
            'services' => Service::where('is_active', true)->count(),
            'new_messages' => ContactMessage::where('status', 'new')->count(),
        ];

        $messages = ContactMessage::latest()->limit(5)->get();
        $projects = Project::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'messages', 'projects'));
    }
}
