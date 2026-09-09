@extends('layouts.app')

@section('content')
<section class="hero" id="home">
    <div class="container hero-grid">
        <div class="hero-copy">
            <p class="eyebrow">{{ $settings?->hero_badge ?: 'Public demo · Laravel + MySQL' }}</p>
            <h1>{{ $settings?->hero_title ?? 'Product concepts, built as a' }} <span>{{ $settings?->hero_highlight ?? 'working Laravel portfolio.' }}</span></h1>
            <p class="hero-lead">{{ $settings?->hero_description ?? 'This site is a working demo: public case studies, an admin CMS, database-backed content, contact inbox, and production deployment.' }}</p>
            <div class="hero-actions">
                <a href="#work" class="btn btn-dark">View concept case studies</a>
                <a href="{{ $settings?->cta_url ?: '#contact' }}" class="text-link">{{ $settings?->cta_label ?: 'Send a message' }}</a>
            </div>
            <dl class="hero-facts" aria-label="Technology used in this demo">
                <div><dt>Application</dt><dd>Laravel 9 + Blade</dd></div>
                <div><dt>Data</dt><dd>MySQL + Eloquent</dd></div>
                <div><dt>Production</dt><dd>Docker + Railway</dd></div>
            </dl>
        </div>

        <aside class="implementation-ledger" aria-label="Implemented features">
            <div class="ledger-head">
                <span>Implementation ledger</span>
                <strong>Public demo</strong>
            </div>
            <div class="ledger-row"><span>Public site</span><b>Responsive Blade views</b></div>
            <div class="ledger-row"><span>Content</span><b>Projects, services, settings</b></div>
            <div class="ledger-row"><span>Admin</span><b>CMS + authenticated routes</b></div>
            <div class="ledger-row"><span>Inbox</span><b>Database-backed contact flow</b></div>
            <div class="ledger-row"><span>Deploy</span><b>Docker + health check</b></div>
            <div class="ledger-note">Everything listed here exists in the repository. Concept project outcomes are intentionally not presented as real client results.</div>
        </aside>
    </div>
</section>

<section class="section about" id="about">
    <div class="container editorial-grid">
        <div class="section-heading">
            <p class="section-kicker">About this demo</p>
            <h2>Built to show the implementation, not invent a company history.</h2>
        </div>
        <div class="about-copy">
            <p>This portfolio is deliberately transparent about what is real. The application and CMS are working software. The case studies are fictional product concepts used to demonstrate information architecture, interface design, and Laravel implementation.</p>
            <p>That distinction keeps the demo useful without presenting invented clients, revenue, retention, testimonials, or conversion lifts as facts.</p>
            <a class="text-link" href="{{ route('projects.index') }}">Browse the case studies</a>
        </div>
    </div>
    <div class="container capability-table" aria-label="Implemented application areas">
        <div><span>01</span><strong>Public portfolio</strong><p>Homepage, project archive, case-study detail, SEO metadata, sitemap, and responsive navigation.</p></div>
        <div><span>02</span><strong>Content management</strong><p>Authenticated project, service, testimonial, settings, and inquiry management.</p></div>
        <div><span>03</span><strong>Production setup</strong><p>MySQL, Docker, persistent media support, security headers, rate limiting, and health checks.</p></div>
    </div>
</section>

<section class="section services" id="services">
    <div class="container section-top">
        <div><p class="section-kicker">What the build covers</p></div>
        <div><h2>A small full-stack surface with enough depth to inspect.</h2><p class="section-lead">The sections below come from database-managed content. They are framed as capabilities of the demo rather than claims about a fictional agency.</p></div>
    </div>

    <div class="container service-list">
        @forelse($services as $service)
            <article class="service-row">
                <span class="service-number">{{ $service->number ?: str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <h3>{{ $service->title }}</h3>
                <div>
                    <p>{{ $service->description }}</p>
                    @if(!empty($service->tags))
                        <div class="tag-list">
                            @foreach($service->tags as $tag)<span>{{ $tag }}</span>@endforeach
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <p>Belum ada capability yang dipublikasikan.</p>
        @endforelse
    </div>
</section>

<section class="section work" id="work">
    <div class="container section-top work-heading">
        <div><p class="section-kicker">Concept case studies</p></div>
        <div class="heading-with-action"><h2>Fictional briefs, clearly labelled, used to show product thinking and implementation.</h2><a class="text-link" href="{{ route('projects.index') }}">View all case studies</a></div>
    </div>

    <div class="container project-showcase">
        @forelse($projects as $project)
            <article class="project-card">
                <a href="{{ route('projects.show', $project) }}" class="project-visual project-{{ $project->theme }} {{ $project->cover_image ? 'has-cover' : '' }}"
                   @if($project->cover_image) style="background-image:url('{{ $project->coverImageUrl() }}')" @endif>
                    @unless($project->cover_image)
                        <div class="concept-canvas">
                            <span>{{ $project->is_concept ? 'Concept case study' : 'Project case study' }}</span>
                            <strong>{{ $project->title }}</strong>
                            <small>{{ $project->category ?? 'Product concept' }}</small>
                            <div class="concept-tags">@foreach(array_slice($project->tags ?? [], 0, 3) as $tag)<i>{{ $tag }}</i>@endforeach</div>
                        </div>
                    @endunless
                    <span class="project-open">Read case study</span>
                </a>
                <div class="project-info">
                    <div><small>{{ $project->is_concept ? 'CONCEPT CASE STUDY' : 'PROJECT CASE STUDY' }} @if($project->project_year) · {{ $project->project_year }} @endif</small><h3><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3></div>
                    <p>{{ $project->summary }}</p>
                </div>
            </article>
        @empty
            <p>Belum ada project yang dipublikasikan.</p>
        @endforelse
    </div>
</section>

<section class="section process">
    <div class="container section-top">
        <div><p class="section-kicker">Implementation notes</p></div>
        <div><h2>Four decisions that keep the demo practical.</h2></div>
    </div>
    <div class="container process-list">
        @foreach([
            ['Database first','Public content is stored in MySQL and edited through the admin instead of being hard-coded into the landing page.'],
            ['Small frontend layer','Blade, vanilla CSS, and small JavaScript behaviors keep the interface understandable without a large UI framework.'],
            ['Production concerns included','Uploads, rate limits, security headers, health checks, migrations, and container startup are part of the example.'],
            ['Claims stay verifiable','Concepts are labelled as concepts. The interface avoids invented testimonials, business metrics, and client outcomes.'],
        ] as $step)
            <article><span>0{{ $loop->iteration }}</span><div><h3>{{ $step[0] }}</h3><p>{{ $step[1] }}</p></div></article>
        @endforeach
    </div>
</section>

<section class="section contact" id="contact">
    <div class="container contact-grid">
        <div class="contact-copy">
            <p class="section-kicker">Contact flow</p>
            <h2>The form is part of the demo too.</h2>
            <p>Messages submitted here are validated, rate-limited, stored in MySQL, and shown in the authenticated admin inbox.</p>
            <div class="contact-details">
                @if($settings?->email)<div><small>Email</small><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></div>@endif
                @if($settings?->location)<div><small>Location</small><span>{{ $settings->location }}</span></div>@endif
            </div>
        </div>

        <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div class="hp-field" aria-hidden="true">
                <label>Website<input type="text" name="website" value="" tabindex="-1" autocomplete="off"></label>
            </div>
            @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert error">Ada beberapa field yang perlu diperiksa.</div>@endif
            <div class="form-intro"><strong>Send a message</strong><p>Use real contact details only if you want a reply.</p></div>
            <div class="field-row"><label>Your name<input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required></label><label>Email<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></label></div>
            <div class="field-row"><label>Company, optional<input type="text" name="company" value="{{ old('company') }}" autocomplete="organization"></label><label>Phone, optional<input type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel"></label></div>
            <label>Budget, optional<select name="budget"><option value="">No budget selected</option>@foreach(['Under Rp25 juta','Rp25 to 50 juta','Rp50 to 100 juta','Rp100 to 250 juta','Rp250 juta+'] as $budget)<option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>@endforeach</select></label>
            <label>Message<textarea name="message" rows="6" placeholder="What would you like to discuss?" required>{{ old('message') }}</textarea></label>
            <button class="btn btn-dark btn-submit" type="submit">Send message</button>
        </form>
    </div>
</section>
@endsection
