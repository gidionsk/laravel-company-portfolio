@extends('layouts.app')

@section('content')
<section class="hero hero-v3" id="home">
    <div class="hero-mesh" aria-hidden="true"></div>
    <div class="container hero-grid hero-grid-v3">
        <div class="hero-copy reveal">
            <div class="hero-badge"><span class="pulse-dot"></span>{{ $settings?->hero_badge ?: 'Available for selected projects' }}</div>
            <h1>{{ $settings?->hero_title ?? 'We design and build products that' }}<br><em>{{ $settings?->hero_highlight ?? 'people remember.' }}</em></h1>
            <p>{{ $settings?->hero_description ?? 'Strategy, design, and technology in one team. We turn complex ideas into digital products that feel clear, fast, and valuable.' }}</p>
            <div class="hero-actions">
                <a href="{{ $settings?->cta_url ?: '#contact' }}" class="btn btn-primary btn-large">{{ $settings?->cta_label ?: 'Start a project' }} <span>↗</span></a>
                <a href="#work" class="text-link">Explore selected work <span>↓</span></a>
            </div>
            <div class="hero-proof">
                <div><strong>{{ max(24, $projects->count() * 12) }}+</strong><span>projects shipped</span></div>
                <div><strong>94%</strong><span>client retention</span></div>
                <div><strong>4.9/5</strong><span>average satisfaction</span></div>
            </div>
        </div>

        <div class="hero-visual hero-visual-v3 reveal delay-1" data-tilt>
            <div class="visual-glow"></div>
            <div class="product-window">
                <div class="product-window-top">
                    <div><i></i><i></i><i></i></div>
                    <span>analytics.workspace</span>
                    <b>LIVE</b>
                </div>
                <div class="product-window-body">
                    <aside>
                        <div class="mini-logo">{{ mb_substr($settings?->company_short_name ?? 'N', 0, 1) }}</div>
                        <span class="active"></span><span></span><span></span><span></span><span></span>
                    </aside>
                    <div class="product-content">
                        <div class="product-head"><div><small>OVERVIEW</small><h3>Business pulse</h3></div><span>Last 30 days⌄</span></div>
                        <div class="metric-cards">
                            <article><span>Revenue</span><strong>$128.4K</strong><small>↗ 18.2%</small></article>
                            <article><span>Conversion</span><strong>4.82%</strong><small>↗ 0.91%</small></article>
                            <article><span>Active users</span><strong>42,891</strong><small>↗ 12.6%</small></article>
                        </div>
                        <div class="hero-chart">
                            <div class="chart-labels"><span>$120K</span><span>$80K</span><span>$40K</span><span>$0</span></div>
                            <svg viewBox="0 0 520 210" preserveAspectRatio="none" aria-hidden="true">
                                <defs><linearGradient id="heroArea" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="var(--accent)" stop-opacity=".35"/><stop offset="1" stop-color="var(--accent)" stop-opacity="0"/></linearGradient></defs>
                                <path d="M0,168 C55,160 70,125 118,138 C170,152 177,89 232,110 C285,130 300,62 356,78 C402,92 436,29 520,38 L520,210 L0,210Z" fill="url(#heroArea)"/>
                                <path d="M0,168 C55,160 70,125 118,138 C170,152 177,89 232,110 C285,130 300,62 356,78 C402,92 436,29 520,38" fill="none" stroke="var(--accent)" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floating-kpi kpi-one"><span>↗</span><div><small>GROWTH</small><strong>+38.2%</strong></div></div>
            <div class="floating-kpi kpi-two"><span>✓</span><div><small>DELIVERY</small><strong>On track</strong></div></div>
        </div>
    </div>

    <div class="container capability-marquee reveal delay-2">
        <span>PRODUCT STRATEGY</span><i>✦</i><span>UI/UX DESIGN</span><i>✦</i><span>WEB DEVELOPMENT</span><i>✦</i><span>MOBILE APPS</span><i>✦</i><span>AUTOMATION</span>
    </div>
</section>

<section class="section about about-v3" id="about">
    <div class="container">
        <div class="section-top section-top-dark reveal">
            <div><span class="section-index">01</span><span class="section-kicker">ABOUT THE STUDIO</span></div>
            <h2>We make complex things<br><em>feel simple.</em></h2>
        </div>
        <div class="about-bento">
            <article class="about-intro reveal">
                <span>THE APPROACH</span>
                <p>We combine product thinking, visual craft, and engineering execution in one compact team. Less handoff, less noise, faster decisions.</p>
                <a href="#contact" class="text-link light-link">Build with us <span>→</span></a>
            </article>
            <article class="bento-stat reveal delay-1"><strong>8+</strong><span>Years of product experience</span></article>
            <article class="bento-stat reveal delay-1"><strong>{{ max(48, $projects->count() * 16) }}</strong><span>Digital launches & iterations</span></article>
            <article class="bento-quote reveal delay-2"><span>“</span><p>Strategy should be visible in the product, not buried in a slide deck.</p></article>
        </div>
    </div>
</section>

<section class="section services services-v3" id="services">
    <div class="container">
        <div class="section-top reveal">
            <div><span class="section-index">02</span><span class="section-kicker">CAPABILITIES</span></div>
            <div><h2>From first idea to<br><em>real traction.</em></h2><p class="section-lead">Pick one capability or bring us in end-to-end. The system is designed to stay flexible around the problem.</p></div>
        </div>

        <div class="service-cards">
            @forelse($services as $service)
                <article class="service-card reveal" data-spotlight>
                    <div class="service-card-top"><span>{{ $service->number ?: str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><b>↗</b></div>
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->description }}</p>
                    @if(!empty($service->tags))
                        <div class="tag-list">
                            @foreach($service->tags as $tag)<span>{{ $tag }}</span>@endforeach
                        </div>
                    @endif
                </article>
            @empty
                <p>Belum ada service yang dipublikasikan.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="section work work-v3" id="work">
    <div class="container">
        <div class="section-top reveal work-heading">
            <div><span class="section-index">03</span><span class="section-kicker">SELECTED WORK</span></div>
            <div class="heading-with-action"><h2>Built to look good.<br><em>Built to work harder.</em></h2><a class="text-link" href="{{ route('projects.index') }}">View all case studies <span>→</span></a></div>
        </div>

        <div class="project-showcase">
            @forelse($projects as $project)
                <article class="project-card project-card-v3 reveal">
                    <a href="{{ route('projects.show', $project) }}" class="project-visual project-{{ $project->theme }} {{ $project->cover_image ? 'has-cover' : '' }}"
                       @if($project->cover_image) style="background-image:url('{{ $project->coverImageUrl() }}')" @endif>
                        <span class="project-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        @unless($project->cover_image)
                            <div class="project-ui project-ui-v3"><div class="project-ui-top"><span></span><span></span><span></span></div><div class="project-ui-body"><div class="project-ui-menu"></div><div class="project-ui-content"><i></i><i></i><i></i><div class="mini-chart"></div></div></div></div>
                        @endunless
                        @if($project->metric)<div class="project-metric"><strong>{{ $project->metric }}</strong><span>{{ $project->metric_label }}</span></div>@endif
                        <span class="project-open">Open case study ↗</span>
                    </a>
                    <div class="project-info project-info-v3">
                        <div><small>{{ strtoupper($project->category ?? 'PROJECT') }} @if($project->project_year) · {{ $project->project_year }} @endif</small><h3><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3></div>
                        <p>{{ $project->summary }}</p>
                    </div>
                </article>
            @empty
                <p>Belum ada project yang dipublikasikan.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="section process process-v3">
    <div class="container">
        <div class="section-top reveal">
            <div><span class="section-index">04</span><span class="section-kicker">HOW WE WORK</span></div>
            <h2>A sharp process.<br><em>No theatre.</em></h2>
        </div>
        <div class="process-timeline">
            @foreach([
                ['Discover','Align the business goal, user problem, constraints, and success metric before touching pixels.'],
                ['Shape','Turn the problem into a focused product direction, flow, prototype, and delivery plan.'],
                ['Build','Design and engineer the experience with a system that stays maintainable after launch.'],
                ['Improve','Measure what matters, learn from real usage, and iterate where it creates the most value.'],
            ] as $step)
                <article class="reveal"><span>0{{ $loop->iteration }}</span><div><h3>{{ $step[0] }}</h3><p>{{ $step[1] }}</p></div></article>
            @endforeach
        </div>
    </div>
</section>

@if($testimonials->isNotEmpty())
<section class="section testimonial testimonial-v3">
    <div class="container">
        <div class="testimonial-slider reveal" data-testimonial-slider>
            <div class="testimonial-track">
                @foreach($testimonials as $testimonial)
                    <article class="testimonial-slide {{ $loop->first ? 'active' : '' }}" data-testimonial-slide>
                        <span class="quote-mark-v3">“</span>
                        <blockquote>{{ $testimonial->quote }}</blockquote>
                        <div class="person"><div class="avatar">{{ collect(explode(' ', $testimonial->name))->map(fn($part) => mb_substr($part, 0, 1))->take(2)->join('') }}</div><div><strong>{{ $testimonial->name }}</strong><span>{{ trim(($testimonial->role ?? '').($testimonial->company ? ', '.$testimonial->company : '')) }}</span></div></div>
                    </article>
                @endforeach
            </div>
            @if($testimonials->count() > 1)
                <div class="testimonial-controls"><button type="button" data-testimonial-prev aria-label="Previous testimonial">←</button><div>@foreach($testimonials as $testimonial)<button type="button" data-testimonial-dot="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-label="Testimonial {{ $loop->iteration }}"></button>@endforeach</div><button type="button" data-testimonial-next aria-label="Next testimonial">→</button></div>
            @endif
        </div>
    </div>
</section>
@endif

<section class="section contact contact-v3" id="contact">
    <div class="container contact-grid">
        <div class="contact-copy reveal">
            <div><span class="section-index">05</span><span class="section-kicker">START SOMETHING</span></div>
            <h2>Have a challenge?<br><em>Bring it here.</em></h2>
            <p>Share what you're trying to build, improve, or simplify. We’ll respond with the clearest next step, not a generic sales pitch.</p>
            <div class="contact-details">
                @if($settings?->email)<div><small>EMAIL</small><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></div>@endif
                @if($settings?->location)<div><small>BASED IN</small><span>{{ $settings->location }}</span></div>@endif
            </div>
        </div>

        <form class="contact-form contact-form-v3 reveal delay-1" method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div class="hp-field" aria-hidden="true">
                <label>Website<input type="text" name="website" value="" tabindex="-1" autocomplete="off"></label>
            </div>
            @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert error">Ada beberapa field yang perlu diperiksa.</div>@endif
            <div class="form-intro"><small>PROJECT BRIEF</small><strong>Tell us enough to understand the shape of the problem.</strong></div>
            <div class="field-row"><label>YOUR NAME<input type="text" name="name" value="{{ old('name') }}" placeholder="Name" required></label><label>WORK EMAIL<input type="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required></label></div>
            <div class="field-row"><label>COMPANY<input type="text" name="company" value="{{ old('company') }}" placeholder="Company / brand"></label><label>WHATSAPP / PHONE<input type="text" name="phone" value="{{ old('phone') }}" placeholder="+62..."></label></div>
            <label>ESTIMATED BUDGET<select name="budget"><option value="">Choose a range</option>@foreach(['< Rp25 juta','Rp25–50 juta','Rp50–100 juta','Rp100–250 juta','Rp250 juta+'] as $budget)<option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>@endforeach</select></label>
            <label>WHAT ARE YOU TRYING TO BUILD?<textarea name="message" rows="5" placeholder="Context, target, timeline, or what is currently not working..." required>{{ old('message') }}</textarea></label>
            <button class="btn btn-primary btn-submit" type="submit">Send project brief <span>↗</span></button>
        </form>
    </div>
</section>
@endsection
