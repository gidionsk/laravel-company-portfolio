@extends('layouts.admin', ['title' => 'Services — Admin'])
@section('content')
<div class="admin-page-head">
    <div><small>CONTENT</small><h1>Services</h1><p>Layanan yang ditampilkan pada homepage.</p></div>
    <a href="{{ route('admin.services.create') }}" class="admin-primary-btn">+ Add service</a>
</div>
<section class="admin-panel">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>No.</th><th>Service</th><th>Tags</th><th>Status</th><th>Order</th><th></th></tr></thead>
            <tbody>
            @forelse($services as $service)
                <tr>
                    <td>{{ $service->number ?: '—' }}</td>
                    <td><strong>{{ $service->title }}</strong><small class="table-subtext">{{ \Illuminate\Support\Str::limit($service->description, 75) }}</small></td>
                    <td>{{ implode(', ', $service->tags ?? []) ?: '—' }}</td>
                    <td><span class="admin-badge {{ $service->is_active ? 'published' : 'draft' }}">{{ $service->is_active ? 'active' : 'hidden' }}</span></td>
                    <td>{{ $service->sort_order }}</td>
                    <td class="admin-actions"><a href="{{ route('admin.services.edit', $service) }}">Edit</a><form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus service ini?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="admin-empty">Belum ada service.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
