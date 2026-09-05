<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::query()->first();
        $services = Service::query()->where('is_active', true)->orderBy('sort_order')->get();
        $projects = Project::query()
            ->where('is_published', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();
        $testimonials = Testimonial::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('home', compact('settings', 'services', 'projects', 'testimonials'));
    }

    public function contact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'budget' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:3000'],
            'website' => ['nullable', 'prohibited'],
        ]);

        unset($validated['website']);
        ContactMessage::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}
