@extends('layouts.admin', ['title' => 'Message from '.$message->name.' — Admin'])
@section('content')
<div class="admin-page-head"><div><small>INQUIRY</small><h1>{{ $message->name }}</h1><p>{{ $message->email }} · {{ $message->created_at->format('d M Y, H:i') }}</p></div><a href="{{ route('admin.messages.index') }}" class="admin-secondary-btn">← Back</a></div>
<div class="admin-form-grid">
    <section class="admin-panel admin-message-detail">
        <div class="admin-message-meta"><div><span>Company</span><strong>{{ $message->company ?: '—' }}</strong></div><div><span>Phone</span><strong>{{ $message->phone ?: '—' }}</strong></div><div><span>Budget</span><strong>{{ $message->budget ?: '—' }}</strong></div></div>
        <div class="admin-message-body"><span>MESSAGE</span><p>{!! nl2br(e($message->message)) !!}</p></div>
        <div class="admin-message-actions"><a class="admin-primary-btn" href="mailto:{{ $message->email }}?subject=Re: Your inquiry">Reply by email ↗</a>@if($message->phone)<a class="admin-secondary-btn" href="https://wa.me/{{ preg_replace('/\D+/', '', $message->phone) }}" target="_blank" rel="noreferrer">WhatsApp ↗</a>@endif</div>
    </section>
    <aside class="admin-form-side">
        <section class="admin-panel admin-form-section">
            <div class="admin-panel-head"><div><small>WORKFLOW</small><h2>Status</h2></div></div>
            <form action="{{ route('admin.messages.update', $message) }}" method="POST" class="admin-form">@csrf @method('PATCH')<label>Status<select name="status">@foreach(['new','read','archived'] as $status)<option value="{{ $status }}" @selected($message->status===$status)>{{ ucfirst($status) }}</option>@endforeach</select></label><button class="admin-primary-btn" type="submit">Update status</button></form>
        </section>
        <section class="admin-panel admin-danger-zone"><strong>Delete inquiry</strong><p>Action ini tidak dapat dibatalkan.</p><form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus inquiry ini permanen?')">@csrf @method('DELETE')<button type="submit">Delete message</button></form></section>
    </aside>
</div>
@endsection
