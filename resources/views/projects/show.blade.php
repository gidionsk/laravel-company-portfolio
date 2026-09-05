@extends('layouts.app', ['title' => $project->title.' — '.($settings?->company_short_name ?? 'Northstar'), 'metaDescription' => $project->summary])

@section('content')
<section class="case-hero case-hero-v3">
    <div class="container reveal">
        <a href="{{ route('projects.index') }}" class="back-link">← All projects</a>
        <div class="case-title-grid">
            <div><span class="section-kicker">{{ strtoupper($project->category ?? 'CASE STUDY') }}</span><h1>{{ $project->title }}</h1></div>
            <div class="case-intro"><p>{{ $project->summary }}</p><div class="case-meta">@if($project->client_name)<span><small>CLIENT</small>{{ $project->client_name }}</span>@endif @if($project->project_year)<span><small>YEAR</small>{{ $project->project_year }}</span>@endif @if($project->project_url)<a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer"><small>LIVE</small>Visit project ↗</a>@endif</div></div>
        </div>

        <div class="case-cover project-{{ $project->theme }} {{ $project->cover_image ? 'has-cover' : '' }}" @if($project->cover_image) style="background-image:url('{{ $project->coverImageUrl() }}')" @endif>
            @unless($project->cover_image)<div class="case-mockup"><div class="project-ui project-ui-v3"><div class="project-ui-top"><span></span><span></span><span></span></div><div class="project-ui-body"><div class="project-ui-menu"></div><div class="project-ui-content"><i></i><i></i><i></i><div class="mini-chart"></div></div></div></div></div>@endunless
            @if($project->metric)<div class="case-metric"><strong>{{ $project->metric }}</strong><span>{{ $project->metric_label }}</span></div>@endif
        </div>
    </div>
</section>

<section class="section case-content case-content-v3">
    <div class="container case-content-grid">
        <aside class="case-sidebar reveal"><span>CAPABILITIES</span><div class="tag-list">@foreach($project->tags ?? [] as $tag)<span>{{ $tag }}</span>@endforeach</div></aside>
        <div class="case-story">
            @if($project->challenge)<article class="reveal"><span>01 / CHALLENGE</span><h2>The problem.</h2><p>{!! nl2br(e($project->challenge)) !!}</p></article>@endif
            @if($project->solution)<article class="reveal"><span>02 / SOLUTION</span><h2>What we built.</h2><p>{!! nl2br(e($project->solution)) !!}</p></article>@endif
            @if($project->result)<article class="reveal"><span>03 / RESULT</span><h2>The outcome.</h2><p>{!! nl2br(e($project->result)) !!}</p></article>@endif
        </div>
    </div>
</section>

@if(!empty($project->gallery_images))
<section class="case-gallery-section">
    <div class="container"><div class="case-gallery">@foreach($project->gallery_images as $image)<figure class="reveal"><img src="{{ $project->galleryImageUrl($image) }}" alt="{{ $project->title }} project image {{ $loop->iteration }}" loading="lazy"></figure>@endforeach</div></div>
</section>
@endif

<section class="case-cta case-cta-v3">
    <div class="container reveal"><span class="section-kicker">NEXT CASE STUDY</span>@if($nextProject)<p>Keep exploring</p><a href="{{ route('projects.show', $nextProject) }}">{{ $nextProject->title }} <span>↗</span></a>@else<p>Have a project in mind?</p><a href="{{ route('home') }}#contact">Start a project <span>↗</span></a>@endif</div>
</section>
@endsection
