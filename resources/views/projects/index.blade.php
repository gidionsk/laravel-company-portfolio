@extends('layouts.app', ['title' => 'Projects — '.($settings?->company_short_name ?? 'Northstar')])

@section('content')
<section class="page-hero page-hero-v3">
    <div class="container reveal">
        <span class="section-kicker">PORTFOLIO / CASE STUDIES</span>
        <h1>Work with a reason<br><em>behind every pixel.</em></h1>
        <p>Selected product, web, mobile, and operational systems built around a clear business problem and a measurable outcome.</p>
    </div>
</section>

<section class="section portfolio-listing portfolio-listing-v3">
    <div class="container">
        @if($categories->isNotEmpty())
            <div class="portfolio-filters reveal" data-project-filters>
                <button class="active" type="button" data-filter="all">All work</button>
                @foreach($categories as $category)<button type="button" data-filter="{{ \Illuminate\Support\Str::slug($category) }}">{{ $category }}</button>@endforeach
            </div>
        @endif

        <div class="project-grid project-grid-all project-grid-filterable">
            @forelse($projects as $project)
                <article class="project-card project-card-v3 reveal" data-project-item data-category="{{ \Illuminate\Support\Str::slug($project->category ?? '') }}">
                    <a href="{{ route('projects.show', $project) }}" class="project-visual project-{{ $project->theme }} {{ $project->cover_image ? 'has-cover' : '' }}" @if($project->cover_image) style="background-image:url('{{ $project->coverImageUrl() }}')" @endif>
                        @unless($project->cover_image)<div class="project-ui project-ui-v3"><div class="project-ui-top"><span></span><span></span><span></span></div><div class="project-ui-body"><div class="project-ui-menu"></div><div class="project-ui-content"><i></i><i></i><i></i><div class="mini-chart"></div></div></div></div>@endunless
                        @if($project->metric)<div class="project-metric"><strong>{{ $project->metric }}</strong><span>{{ $project->metric_label }}</span></div>@endif
                        <span class="project-open">Open case study ↗</span>
                    </a>
                    <div class="project-info project-info-v3"><div><small>{{ strtoupper($project->category ?? 'PROJECT') }} @if($project->project_year) · {{ $project->project_year }} @endif</small><h3><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3></div><p>{{ $project->summary }}</p></div>
                </article>
            @empty
                <p>Belum ada project.</p>
            @endforelse
        </div>
        <div class="pagination-wrap">{{ $projects->links() }}</div>
    </div>
</section>
@endsection
