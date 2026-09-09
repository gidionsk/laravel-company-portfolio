@extends('layouts.admin', ['title' => 'Projects | Admin'])

@section('content')
<div class="admin-page-head">
    <div><small>Content</small><h1>Projects</h1><p>Manage real projects or clearly labelled concept case studies. Leave client and metric fields empty when they are not verifiable.</p></div>
    <a href="{{ route('admin.projects.create') }}" class="admin-primary-btn">Add project</a>
</div>

<section class="admin-panel">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Project</th><th>Category</th><th>Type</th><th>Status</th><th>Featured</th><th></th></tr></thead>
            <tbody>
            @forelse($projects as $project)
                <tr>
                    <td><div class="admin-project-cell"><span class="admin-project-thumb project-{{ $project->theme }}">{{ mb_substr($project->title,0,1) }}</span><div><strong>{{ $project->title }}</strong><small>/projects/{{ $project->slug }}</small></div></div></td>
                    <td>{{ $project->category ?: 'Not set' }}</td>
                    <td>{{ $project->is_concept ? 'Concept' : 'Project' }}</td>
                    <td><span class="admin-badge {{ $project->is_published ? 'published' : 'draft' }}">{{ $project->is_published ? 'published' : 'draft' }}</span></td>
                    <td>{{ $project->is_featured ? 'Yes' : 'No' }}</td>
                    <td class="admin-actions">
                        @if($project->is_published)<a href="{{ route('projects.show', $project) }}" target="_blank">View</a>@endif
                        <a href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus project ini?')">@csrf @method('DELETE')<button type="submit">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="admin-empty">Belum ada project. Tambahkan project pertama kamu.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $projects->links() }}</div>
</section>
@endsection
