@extends('layouts.admin', ['title' => 'Testimonials — Admin'])
@section('content')
<div class="admin-page-head"><div><small>CONTENT</small><h1>Testimonials</h1><p>Kelola social proof yang tampil pada website.</p></div><a href="{{ route('admin.testimonials.create') }}" class="admin-primary-btn">+ Add testimonial</a></div>
<div class="admin-card-grid">
    @forelse($testimonials as $testimonial)
        <article class="admin-quote-card">
            <div class="admin-quote-top"><span class="admin-badge {{ $testimonial->is_active ? 'published' : 'draft' }}">{{ $testimonial->is_active ? 'active' : 'hidden' }}</span><small>#{{ $testimonial->sort_order }}</small></div>
            <blockquote>“{{ $testimonial->quote }}”</blockquote>
            <div class="admin-quote-person"><strong>{{ $testimonial->name }}</strong><span>{{ trim(($testimonial->role ?? '').($testimonial->company ? ', '.$testimonial->company : '')) }}</span></div>
            <div class="admin-actions"><a href="{{ route('admin.testimonials.edit', $testimonial) }}">Edit</a><form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Hapus testimonial ini?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></div>
        </article>
    @empty
        <div class="admin-panel admin-empty">Belum ada testimonial.</div>
    @endforelse
</div>
@endsection
