@extends('layouts.app', ['title' => 'Concept case studies | '.($settings?->company_short_name ?? 'Portfolio')])

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="section-kicker">Concept case studies</p>
        <h1>Fictional product briefs used to show the work.</h1>
        <p>These projects are not client engagements. Each one is a structured concept used to demonstrate product framing, interface decisions, and the case-study system in this Laravel application.</p>
    </div>
</section>

<section class="section portfolio-listing">
    <div class="container">
        @if($categories->isNotEmpty())
            <div class="portfolio-filters" data-project-filters aria-label="Filter case studies">
                <button class="active" type="button" data-filter="all" aria-pressed="true">All</button>
                @foreach($categories as $category)<button type="button" data-filter="{{ \Illuminate\Support\Str::slug($category) }}" aria-pressed="false">{{ $category }}</button>@endforeach
            </div>
        @endif

        <div class="project-grid project-grid-all project-grid-filterable">
            @forelse($projects as $project)
                <article class="project-card" data-project-item data-category="{{ \Illuminate\Support\Str::slug($project->category ?? '') }}">
                    <a href="{{ route('projects.show', $project) }}" class="project-visual project-{{ $project->theme }} {{ $project->cover_image ? 'has-cover' : '' }}" @if($project->cover_image) style="background-image:url('{{ $project->coverImageUrl() }}')" @endif>
                        @unless($project->cover_image)
                            @if(in_array($project->slug, ['nexa-finance','aruna-living','flowdesk','vanta-commerce']))
                                <img class="project-concept-image" src="{{ asset('images/visuals/'.$project->slug.'.svg') }}" alt="{{ $project->title }} concept interface preview" width="1200" height="840" loading="lazy">
                            @else
                                <div class="concept-canvas">
                                    <span>{{ $project->is_concept ? 'Concept case study' : 'Project case study' }}</span>
                                    <strong>{{ $project->title }}</strong>
                                    <small>{{ $project->category ?? 'Product concept' }}</small>
                                    <div class="concept-tags">@foreach(array_slice($project->tags ?? [], 0, 3) as $tag)<i>{{ $tag }}</i>@endforeach</div>
                                </div>
                            @endif
                        @endunless
                        <span class="project-open">Read case study</span>
                    </a>
                    <div class="project-info"><div><small>{{ $project->is_concept ? 'CONCEPT CASE STUDY' : 'PROJECT CASE STUDY' }} @if($project->project_year) · {{ $project->project_year }} @endif</small><h3><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3></div><p>{{ $project->summary }}</p></div>
                </article>
            @empty
                <p>Belum ada case study.</p>
            @endforelse
        </div>
        <div class="pagination-wrap">{{ $projects->links() }}</div>
    </div>
</section>
@endsection
