@extends('layouts.admin', ['title' => 'Dashboard — Admin'])

@section('content')
<div class="admin-page-head">
    <div><small>OVERVIEW</small><h1>Dashboard</h1><p>Ringkasan website dan aktivitas inquiry terbaru.</p></div>
    <a href="{{ route('admin.projects.create') }}" class="admin-primary-btn">+ New project</a>
</div>

<div class="admin-stat-grid">
    <article><span>Total projects</span><strong>{{ $stats['projects'] }}</strong><small>{{ $stats['published'] }} published</small></article>
    <article><span>Active services</span><strong>{{ $stats['services'] }}</strong><small>Shown on homepage</small></article>
    <article><span>New inquiries</span><strong>{{ $stats['new_messages'] }}</strong><small>Need attention</small></article>
    <article><span>Website</span><strong class="status-online">Live</strong><small>Public pages enabled</small></article>
</div>

<div class="admin-two-col">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><small>RECENT</small><h2>Messages</h2></div><a href="{{ route('admin.messages.index') }}">View all →</a></div>
        <div class="admin-list">
            @forelse($messages as $message)
                <a href="{{ route('admin.messages.show', $message) }}" class="admin-list-row">
                    <div><strong>{{ $message->name }}</strong><span>{{ $message->company ?: $message->email }}</span></div>
                    <span class="admin-badge status-{{ $message->status }}">{{ $message->status }}</span>
                </a>
            @empty
                <div class="admin-empty">Belum ada inquiry.</div>
            @endforelse
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><small>LATEST</small><h2>Projects</h2></div><a href="{{ route('admin.projects.index') }}">Manage →</a></div>
        <div class="admin-list">
            @forelse($projects as $project)
                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-list-row">
                    <div><strong>{{ $project->title }}</strong><span>{{ $project->category }}</span></div>
                    <span class="admin-badge {{ $project->is_published ? 'published' : 'draft' }}">{{ $project->is_published ? 'published' : 'draft' }}</span>
                </a>
            @empty
                <div class="admin-empty">Belum ada project.</div>
            @endforelse
        </div>
    </section>
</div>
@endsection
