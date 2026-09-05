@extends('layouts.admin', ['title' => 'Edit Service — Admin'])
@section('content')
<div class="admin-page-head"><div><small>SERVICES / EDIT</small><h1>{{ $service->title }}</h1><p>Update informasi layanan.</p></div></div>
<form action="{{ route('admin.services.update', $service) }}" method="POST">@csrf @method('PUT') @include('admin.services._form')</form>
@endsection
