@extends('layouts.admin', ['title' => 'Edit '.$project->title.' — Admin'])
@section('content')
<div class="admin-page-head"><div><small>PROJECTS / EDIT</small><h1>{{ $project->title }}</h1><p>Update isi, visual, dan status publikasi project.</p></div>@if($project->is_published)<a href="{{ route('projects.show', $project) }}" class="admin-secondary-btn" target="_blank">Open live ↗</a>@endif</div>
<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.projects._form')</form>
@endsection
