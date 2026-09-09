@php($editing = isset($project))
<div class="admin-form-grid">
    <div class="admin-form-main">
        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>Project info</small><h2>Basic information</h2></div></div>
            <div class="admin-form two-cols"><label>Project title<input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required></label><label>Category<input type="text" name="category" value="{{ old('category', $project->category ?? '') }}" placeholder="Fintech product concept"></label></div>
            <div class="admin-form two-cols"><label>Client or brand, optional<input type="text" name="client_name" value="{{ old('client_name', $project->client_name ?? '') }}" placeholder="Leave empty for concept work"><small>Only name a real client or brand when the project is genuine and publishable.</small></label><label>Project year<input type="number" name="project_year" min="2000" max="2100" value="{{ old('project_year', $project->project_year ?? date('Y')) }}"></label></div>
            <div class="admin-form"><label>Live project URL<input type="url" name="project_url" value="{{ old('project_url', $project->project_url ?? '') }}" placeholder="https://..."></label><label>Summary<textarea name="summary" rows="4" required>{{ old('summary', $project->summary ?? '') }}</textarea></label></div>
        </section>

        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>Case study</small><h2>Project story</h2></div></div>
            <div class="admin-form"><label>Premise<textarea name="challenge" rows="6" placeholder="Problem or premise the case study explores...">{{ old('challenge', $project->challenge ?? '') }}</textarea></label><label>Implementation<textarea name="solution" rows="6" placeholder="How the product direction is framed...">{{ old('solution', $project->solution ?? '') }}</textarea></label><label>Demonstration<textarea name="result" rows="6" placeholder="What this case study demonstrates. Do not invent measured outcomes...">{{ old('result', $project->result ?? '') }}</textarea></label></div>
        </section>

        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>Gallery</small><h2>Case study visuals</h2></div></div>
            <div class="admin-form"><label>Upload gallery images<input type="file" name="gallery_images[]" accept="image/*" multiple><small>Maksimal 8 gambar per submit, masing-masing 6 MB.</small></label></div>
            @if($editing && !empty($project->gallery_images))
                <div class="admin-gallery-grid">@foreach($project->gallery_images as $image)<label class="admin-gallery-item"><img src="{{ $project->galleryImageUrl($image) }}" alt="Gallery image"><span><input type="checkbox" name="remove_gallery[]" value="{{ $image }}"> Remove</span></label>@endforeach</div>
            @endif
        </section>
    </div>

    <div class="admin-form-side">
        <section class="admin-panel admin-form-section"><div class="admin-panel-head"><div><small>Publishing</small><h2>Visibility</h2></div></div><div class="admin-form"><label class="admin-check"><input type="checkbox" name="is_concept" value="1" @checked(old('is_concept', $project->is_concept ?? true))> Concept case study</label><label class="admin-check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))> Published</label><label class="admin-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured ?? false))> Featured on homepage</label><label>Sort order<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $project->sort_order ?? 0) }}"></label></div></section>

        <section class="admin-panel admin-form-section"><div class="admin-panel-head"><div><small>Visual</small><h2>Presentation</h2></div></div><div class="admin-form"><label>Theme<select name="theme" required>@foreach(['indigo','sand','mint','coral','sky','dark'] as $theme)<option value="{{ $theme }}" @selected(old('theme', $project->theme ?? 'indigo') === $theme)>{{ ucfirst($theme) }}</option>@endforeach</select></label><label>Cover image<input type="file" name="cover_image" accept="image/*"><small>JPG/PNG/WebP, max 6 MB. Jalankan storage:link.</small></label>@if($editing && $project->cover_image)<img class="admin-cover-preview" src="{{ $project->coverImageUrl() }}" alt="Current cover">@endif</div></section>

        <section class="admin-panel admin-form-section"><div class="admin-panel-head"><div><small>Evidence</small><h2>Metric and tags</h2></div></div><div class="admin-form"><label>Verified metric, optional<input type="text" name="metric" value="{{ old('metric', $project->metric ?? '') }}" placeholder="Leave empty for concept work"><small>Use only a substantiated metric from a real project.</small></label><label>Metric label<input type="text" name="metric_label" value="{{ old('metric_label', $project->metric_label ?? '') }}" placeholder="Only when a verified metric exists"></label><label>Tags<input type="text" name="tags_text" value="{{ old('tags_text', isset($project) ? implode(', ', $project->tags ?? []) : '') }}" placeholder="Laravel, UI/UX, API"><small>Pisahkan dengan koma.</small></label></div></section>
    </div>
</div>
<div class="admin-form-footer"><a href="{{ route('admin.projects.index') }}" class="admin-secondary-btn">Cancel</a><button type="submit" class="admin-primary-btn">{{ $editing ? 'Save changes' : 'Create project' }}</button></div>
