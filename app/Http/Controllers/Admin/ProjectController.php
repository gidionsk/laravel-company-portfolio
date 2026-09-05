<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()->orderBy('sort_order')->orderByDesc('created_at')->paginate(12);
        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['tags'] = $this->tags($request->input('tags_text'));
        $data['gallery_images'] = [];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', config('portfolio.media_disk'));
        }

        if ($request->hasFile('gallery_images')) {
            $data['gallery_images'] = collect($request->file('gallery_images'))
                ->map(fn ($image) => $image->store('projects/gallery', config('portfolio.media_disk')))
                ->all();
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request);
        if ($project->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $project->id);
        }
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['tags'] = $this->tags($request->input('tags_text'));

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk(config('portfolio.media_disk'))->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('projects', config('portfolio.media_disk'));
        }

        $gallery = collect($project->gallery_images ?? []);
        $remove = collect($request->input('remove_gallery', []))->intersect($gallery);
        $remove->each(fn ($path) => Storage::disk(config('portfolio.media_disk'))->delete($path));
        $gallery = $gallery->reject(fn ($path) => $remove->contains($path));

        if ($request->hasFile('gallery_images')) {
            $newImages = collect($request->file('gallery_images'))
                ->map(fn ($image) => $image->store('projects/gallery', config('portfolio.media_disk')));
            $gallery = $gallery->concat($newImages);
        }

        $data['gallery_images'] = $gallery->values()->all();
        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->cover_image) {
            Storage::disk(config('portfolio.media_disk'))->delete($project->cover_image);
        }

        foreach ($project->gallery_images ?? [] as $image) {
            Storage::disk(config('portfolio.media_disk'))->delete($image);
        }

        $project->delete();

        return back()->with('success', 'Project berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'client_name' => ['nullable', 'string', 'max:160'],
            'project_year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'summary' => ['required', 'string', 'max:1200'],
            'challenge' => ['nullable', 'string', 'max:8000'],
            'solution' => ['nullable', 'string', 'max:8000'],
            'result' => ['nullable', 'string', 'max:8000'],
            'metric' => ['nullable', 'string', 'max:50'],
            'metric_label' => ['nullable', 'string', 'max:120'],
            'theme' => ['required', 'in:indigo,sand,mint,coral,sky,dark'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'cover_image' => ['nullable', 'image', 'max:6144'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['image', 'max:6144'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['string'],
        ]);
    }

    private function tags(?string $value): array
    {
        return collect(explode(',', (string) $value))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'project';
        $slug = $base;
        $counter = 2;

        while (Project::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
