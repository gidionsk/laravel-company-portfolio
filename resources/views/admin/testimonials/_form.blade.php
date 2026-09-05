@php($editing = isset($testimonial))
<section class="admin-panel admin-form-section admin-narrow-panel">
    <div class="admin-panel-head"><div><small>TESTIMONIAL</small><h2>{{ $editing ? 'Edit testimonial' : 'New testimonial' }}</h2></div></div>
    <div class="admin-form two-cols">
        <label>Name<input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required></label>
        <label>Company<input type="text" name="company" value="{{ old('company', $testimonial->company ?? '') }}"></label>
        <label>Role<input type="text" name="role" value="{{ old('role', $testimonial->role ?? '') }}"></label>
        <label>Sort order<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}"></label>
    </div>
    <div class="admin-form"><label>Quote<textarea name="quote" rows="7" required>{{ old('quote', $testimonial->quote ?? '') }}</textarea></label><label class="admin-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active ?? true))> Active</label></div>
</section>
<div class="admin-form-footer admin-narrow-footer"><a href="{{ route('admin.testimonials.index') }}" class="admin-secondary-btn">Cancel</a><button class="admin-primary-btn" type="submit">{{ $editing ? 'Save changes' : 'Create testimonial' }}</button></div>
