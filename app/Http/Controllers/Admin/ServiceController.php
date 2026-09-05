<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Service::create($this->payload($request));
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->payload($request));
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return back()->with('success', 'Service berhasil dihapus.');
    }

    private function payload(Request $request): array
    {
        $data = $request->validate([
            'number' => ['nullable', 'string', 'max:10'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:1200'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $data['tags'] = collect(explode(',', (string) $request->input('tags_text')))
            ->map(fn ($tag) => trim($tag))->filter()->unique()->values()->all();
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
