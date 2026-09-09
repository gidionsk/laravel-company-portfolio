@extends('layouts.admin', ['title' => 'Website Settings | Admin'])
@section('content')
<div class="admin-page-head">
    <div><small>Configuration</small><h1>Website settings</h1><p>Manage demo metadata, homepage copy, contact information, and the restrained accent used by the interface.</p></div>
    <a href="{{ route('home') }}" class="admin-secondary-btn" target="_blank">Preview website</a>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">@csrf @method('PUT')
<div class="admin-form-grid">
    <div class="admin-form-main">
        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>Metadata</small><h2>Demo identity</h2></div></div>
            <div class="admin-form two-cols">
                <label>Company name<input type="text" name="company_name" value="{{ old('company_name', $settings->company_name) }}" required></label>
                <label>Short name<input type="text" name="company_short_name" value="{{ old('company_short_name', $settings->company_short_name) }}" required></label>
            </div>
            <div class="admin-form"><label>Tagline<input type="text" name="tagline" value="{{ old('tagline', $settings->tagline) }}" placeholder="Laravel portfolio demo"></label></div>
        </section>

        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>Homepage</small><h2>Headline</h2></div></div>
            <div class="admin-form">
                <label>Availability / badge<input type="text" name="hero_badge" value="{{ old('hero_badge', $settings->hero_badge) }}" placeholder="Public demo · Laravel + MySQL"></label>
                <label>Hero title<input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}"></label>
                <label>Highlighted phrase<input type="text" name="hero_highlight" value="{{ old('hero_highlight', $settings->hero_highlight) }}"></label>
                <label>Description<textarea name="hero_description" rows="5">{{ old('hero_description', $settings->hero_description) }}</textarea></label>
            </div>
        </section>

        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>SEO</small><h2>Search and sharing</h2></div></div>
            <div class="admin-form">
                <label>SEO title<input type="text" name="seo_title" maxlength="70" value="{{ old('seo_title', $settings->seo_title) }}" placeholder="Portfolio Demo | Laravel case studies"><small>Ideal sekitar 50 to 60 karakter.</small></label>
                <label>SEO description<textarea name="seo_description" maxlength="180" rows="4" placeholder="Short description for Google and social sharing...">{{ old('seo_description', $settings->seo_description) }}</textarea></label>
            </div>
        </section>
    </div>

    <div class="admin-form-side">
        <section class="admin-panel admin-form-section brand-theme-panel">
            <div class="admin-panel-head"><div><small>Accent</small><h2>Interface accent</h2></div></div>
            <div class="theme-preview-card" style="--preview-a: {{ old('accent_color', $settings->accent_color ?? '#2f6b52') }}; --preview-b: {{ old('accent_color_secondary', $settings->accent_color_secondary ?? '#b8613f') }};"><span></span><b>{{ $settings->company_short_name ?: 'BRAND' }}</b><p>Accent preview</p></div>
            <div class="admin-form two-cols">
                <label>Primary accent<div class="color-field"><input type="color" value="{{ old('accent_color', $settings->accent_color ?? '#2f6b52') }}" data-color-picker><input type="text" name="accent_color" value="{{ old('accent_color', $settings->accent_color ?? '#2f6b52') }}" data-color-text required></div></label>
                <label>Secondary accent<div class="color-field"><input type="color" value="{{ old('accent_color_secondary', $settings->accent_color_secondary ?? '#b8613f') }}" data-color-picker><input type="text" name="accent_color_secondary" value="{{ old('accent_color_secondary', $settings->accent_color_secondary ?? '#b8613f') }}" data-color-text required></div></label>
            </div>
            <div class="admin-form"><label>CTA label<input type="text" name="cta_label" value="{{ old('cta_label', $settings->cta_label) }}" placeholder="Send a message"></label><label>CTA URL<input type="text" name="cta_url" value="{{ old('cta_url', $settings->cta_url) }}" placeholder="#contact atau https://..."></label></div>
        </section>

        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>Contact</small><h2>Public details</h2></div></div>
            <div class="admin-form"><label>Email<input type="email" name="email" value="{{ old('email', $settings->email) }}"></label><label>Phone<input type="text" name="phone" value="{{ old('phone', $settings->phone) }}"></label><label>WhatsApp number<input type="text" name="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}" placeholder="62812..."></label><label>Location<input type="text" name="location" value="{{ old('location', $settings->location) }}"></label></div>
        </section>

        <section class="admin-panel admin-form-section"><div class="admin-panel-head"><div><small>Social</small><h2>Links</h2></div></div><div class="admin-form"><label>LinkedIn URL<input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}"></label><label>Instagram URL<input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}"></label></div></section>
    </div>
</div>
<div class="admin-form-footer"><span></span><button class="admin-primary-btn" type="submit">Save settings</button></div>
</form>
@endsection
