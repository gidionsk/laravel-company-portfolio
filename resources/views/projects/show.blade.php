@extends('layouts.app', [
    'title' => $project->title.' | '.($project->is_concept ? 'Concept case study' : 'Project case study'),
    'metaDescription' => $project->summary,
])

@section('content')

<section class="case-hero">
    <div class="container">
        <a href="{{ route('projects.index') }}" class="back-link">
            Back to case studies
        </a>

        <div class="case-title-grid">
            <div>
                <p class="section-kicker">
                    {{ $project->is_concept ? 'Concept case study' : 'Project case study' }}
                </p>

                <h1>{{ $project->title }}</h1>
            </div>

            <div class="case-intro">
                <p>{{ $project->summary }}</p>

                <div class="case-meta">
                    <span>
                        <small>Type</small>
                        {{ $project->is_concept ? 'Fictional product concept' : 'Published project' }}
                    </span>

                    @if (!$project->is_concept && $project->client_name)
                        <span>
                            <small>Client</small>
                            {{ $project->client_name }}
                        </span>
                    @endif

                    @if ($project->project_year)
                        <span>
                            <small>Year</small>
                            {{ $project->project_year }}
                        </span>
                    @endif

                    @if ($project->project_url)
                        <a
                            href="{{ $project->project_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <small>External link</small>
                            Open prototype
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div
            class="case-cover project-{{ $project->theme }} {{ $project->cover_image ? 'has-cover' : '' }}"
            @if ($project->cover_image)
                style="background-image:url('{{ $project->coverImageUrl() }}')"
            @endif
        >
            @unless ($project->cover_image)
                <div class="concept-canvas concept-canvas-large">
                    <span>
                        {{ $project->is_concept ? 'Concept case study' : 'Project case study' }}
                    </span>

                    <strong>{{ $project->title }}</strong>

                    <small>
                        {{ $project->category ?? 'Product concept' }}
                    </small>

                    <div class="concept-tags">
                        @foreach ($project->tags ?? [] as $tag)
                            <i>{{ $tag }}</i>
                        @endforeach
                    </div>
                </div>
            @endunless
        </div>
    </div>
</section>

<section class="section case-content">
    <div class="container case-content-grid">
        <aside class="case-sidebar">
            <span>Focus areas</span>

            <div class="tag-list">
                @foreach ($project->tags ?? [] as $tag)
                    <span>{{ $tag }}</span>
                @endforeach
            </div>

            @if ($project->is_concept)
                <p>
                    This case study is a fictional brief created for demonstration.
                    It does not represent a real client engagement or measured
                    business outcome.
                </p>
            @endif
        </aside>

        <div class="case-story">
            @if ($project->challenge)
                <article>
                    <span>01 / Premise</span>

                    <h2>
                        {{ $project->is_concept
                            ? 'What the concept needs to solve'
                            : 'What the project needed to solve' }}
                    </h2>

                    <p>{!! nl2br(e($project->challenge)) !!}</p>
                </article>
            @endif

            @if ($project->solution)
                <article>
                    <span>02 / Implementation</span>

                    <h2>
                        {{ $project->is_concept
                            ? 'How the product direction is framed'
                            : 'How the solution was implemented' }}
                    </h2>

                    <p>{!! nl2br(e($project->solution)) !!}</p>
                </article>
            @endif

            @if ($project->result)
                <article>
                    <span>03 / Demonstration</span>

                    <h2>
                        {{ $project->is_concept
                            ? 'What this case study is intended to show'
                            : 'What the project delivered' }}
                    </h2>

                    <p>{!! nl2br(e($project->result)) !!}</p>
                </article>
            @endif
        </div>
    </div>
</section>

@if (!empty($project->gallery_images))
    <section class="case-gallery-section">
        <div class="container">
            <div class="case-gallery">
                @foreach ($project->gallery_images as $image)
                    <figure>
                        <img
                            src="{{ $project->galleryImageUrl($image) }}"
                            alt="{{ $project->title }} concept image {{ $loop->iteration }}"
                            loading="lazy"
                        >
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="case-cta">
    <div class="container">
        <p class="section-kicker">Continue</p>

        @if ($nextProject)
            <p>Next case study</p>

            <a href="{{ route('projects.show', $nextProject) }}">
                {{ $nextProject->title }}
            </a>
        @else
            <p>Return to the project archive</p>

            <a href="{{ route('projects.index') }}">
                All case studies
            </a>
        @endif
    </div>
</section>

@endsection
