@php($editing = isset($service))
<section class="admin-panel admin-form-section admin-narrow-panel">
    <div class="admin-panel-head"><div><small>SERVICE</small><h2>{{ $editing ? 'Edit service' : 'New service' }}</h2></div></div>
    <div class="admin-form two-cols">
        <label>Number<input type="text" name="number" value="{{ old('number', $service->number ?? '') }}" placeholder="01"></label>
        <label>Sort order<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $service->sort_order ?? 0) }}"></label>
    </div>
    <div class="admin-form">
        <label>Title<input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" required></label>
        <label>Description<textarea name="description" rows="6" required>{{ old('description', $service->description ?? '') }}</textarea></label>
        <label>Tags<input type="text" name="tags_text" value="{{ old('tags_text', isset($service) ? implode(', ', $service->tags ?? []) : '') }}" placeholder="Web Development, Mobile App"><small>Pisahkan dengan koma.</small></label>
        <label class="admin-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true))> Active on homepage</label>
    </div>
</section>
<div class="admin-form-footer admin-narrow-footer"><a href="{{ route('admin.services.index') }}" class="admin-secondary-btn">Cancel</a><button class="admin-primary-btn" type="submit">{{ $editing ? 'Save changes' : 'Create service' }}</button></div>
