@extends('layouts.admin', ['title' => 'New Testimonial — Admin'])
@section('content')
<div class="admin-page-head"><div><small>TESTIMONIALS / NEW</small><h1>Add testimonial</h1><p>Tambahkan testimonial dari client.</p></div></div>
<form action="{{ route('admin.testimonials.store') }}" method="POST">@csrf @include('admin.testimonials._form')</form>
@endsection
