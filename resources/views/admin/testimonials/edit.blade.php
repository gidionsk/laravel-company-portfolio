@extends('layouts.admin', ['title' => 'Edit Testimonial — Admin'])
@section('content')
<div class="admin-page-head"><div><small>TESTIMONIALS / EDIT</small><h1>{{ $testimonial->name }}</h1><p>Update testimonial client.</p></div></div>
<form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">@csrf @method('PUT') @include('admin.testimonials._form')</form>
@endsection
