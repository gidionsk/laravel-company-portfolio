@extends('layouts.admin', ['title' => 'New Service — Admin'])
@section('content')
<div class="admin-page-head"><div><small>SERVICES / NEW</small><h1>Add service</h1><p>Tambahkan capability atau layanan baru.</p></div></div>
<form action="{{ route('admin.services.store') }}" method="POST">@csrf @include('admin.services._form')</form>
@endsection
