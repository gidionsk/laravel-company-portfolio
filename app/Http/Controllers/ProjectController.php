<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::query()->first();
        $projects = Project::query()
            ->where('is_published', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(9);
        $categories = Project::query()
            ->where('is_published', true)
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('projects.index', compact('settings', 'projects', 'categories'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $settings = SiteSetting::query()->first();
        $nextProject = Project::query()
            ->where('is_published', true)
            ->where('id', '!=', $project->id)
            ->orderByRaw('CASE WHEN id > ? THEN 0 ELSE 1 END', [$project->id])
            ->orderBy('id')
            ->first();

        return view('projects.show', compact('settings', 'project', 'nextProject'));
    }
}
