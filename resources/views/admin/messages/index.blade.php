@extends('layouts.admin', ['title' => 'Messages — Admin'])
@section('content')
<div class="admin-page-head"><div><small>INQUIRIES</small><h1>Messages</h1><p>Semua inquiry yang masuk dari contact form website.</p></div></div>
<div class="admin-filter-row">
    <a href="{{ route('admin.messages.index') }}" class="{{ !request('status') ? 'active' : '' }}">All</a>
    <a href="{{ route('admin.messages.index', ['status'=>'new']) }}" class="{{ request('status')==='new' ? 'active' : '' }}">New</a>
    <a href="{{ route('admin.messages.index', ['status'=>'read']) }}" class="{{ request('status')==='read' ? 'active' : '' }}">Read</a>
    <a href="{{ route('admin.messages.index', ['status'=>'archived']) }}" class="{{ request('status')==='archived' ? 'active' : '' }}">Archived</a>
</div>
<section class="admin-panel">
    <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Sender</th><th>Company</th><th>Budget</th><th>Status</th><th>Received</th><th></th></tr></thead><tbody>
    @forelse($messages as $message)
        <tr>
            <td><strong>{{ $message->name }}</strong><small class="table-subtext">{{ $message->email }}</small></td>
            <td>{{ $message->company ?: '—' }}</td><td>{{ $message->budget ?: '—' }}</td>
            <td><span class="admin-badge status-{{ $message->status }}">{{ $message->status }}</span></td>
            <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
            <td class="admin-actions"><a href="{{ route('admin.messages.show', $message) }}">Open</a></td>
        </tr>
    @empty<tr><td colspan="6"><div class="admin-empty">Tidak ada message pada filter ini.</div></td></tr>@endforelse
    </tbody></table></div>
    <div class="admin-pagination">{{ $messages->links() }}</div>
</section>
@endsection
