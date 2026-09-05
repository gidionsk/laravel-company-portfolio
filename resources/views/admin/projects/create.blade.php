@extends('layouts.admin', ['title' => 'New Project — Admin'])
@section('content')
<div class="admin-page-head"><div><small>PROJECTS / NEW</small><h1>Add project</h1><p>Buat project baru dan case study untuk portfolio.</p></div></div>
<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">@csrf @include('admin.projects._form')</form>
@endsection
