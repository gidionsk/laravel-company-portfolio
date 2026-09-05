<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = SiteSetting::firstOrCreate([]);
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:160'],
            'company_short_name' => ['required', 'string', 'max:40'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'hero_badge' => ['nullable', 'string', 'max:120'],
            'hero_title' => ['nullable', 'string', 'max:200'],
            'hero_highlight' => ['nullable', 'string', 'max:100'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'accent_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'accent_color_secondary' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'cta_label' => ['nullable', 'string', 'max:80'],
            'cta_url' => ['nullable', 'string', 'max:255', 'regex:/^(?:#[A-Za-z0-9_-]+|\/[^\s]*|https?:\/\/[^\s]+)$/i'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:160'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:70'],
            'seo_description' => ['nullable', 'string', 'max:180'],
        ], [
            'accent_color.regex' => 'Accent color harus berupa HEX, contoh #7357ff.',
            'accent_color_secondary.regex' => 'Secondary accent harus berupa HEX, contoh #29d3b2.',
            'cta_url.regex' => 'CTA URL harus berupa anchor (#contact), path internal (/projects), atau URL http/https.',
        ]);

        SiteSetting::firstOrCreate([])->update($data);
        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
