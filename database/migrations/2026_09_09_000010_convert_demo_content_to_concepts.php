<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('site_settings')->where('id', 1)->whereIn('company_name', ['Northstar Studio', 'Portfolio Demo'])->update([
            'company_name' => 'Portfolio Demo',
            'company_short_name' => 'PORTFOLIO',
            'tagline' => 'A working Laravel portfolio demo with concept case studies.',
            'hero_badge' => 'Public demo · Laravel + MySQL',
            'hero_title' => 'Product concepts, built as a',
            'hero_highlight' => 'working Laravel portfolio.',
            'hero_description' => 'This site is a working demo: public case studies, an admin CMS, database-backed content, contact inbox, and production deployment.',
            'accent_color' => '#2f6b52',
            'accent_color_secondary' => '#b8613f',
            'cta_label' => 'Send a message',
            'cta_url' => '#contact',
            'seo_title' => 'Portfolio Demo | Laravel case studies',
            'seo_description' => 'Public Laravel portfolio demo with concept case studies, a working CMS, MySQL content, and production deployment.',
        ]);

        $projects = [
            'nexa-finance' => [
                'category' => 'Fintech product concept',
                'client_name' => null,
                'summary' => 'Concept case study for a transaction product that reduces friction and makes key account actions easier to understand.',
                'challenge' => 'The fictional brief assumes a transaction flow with too many steps, weak status feedback, and inconsistent patterns across common account actions.',
                'solution' => 'The concept focuses on a shorter transaction journey, clearer confirmation states, reusable interface patterns, and an information structure that can be represented cleanly in a product system.',
                'result' => 'This case study demonstrates how a fintech brief can be structured into a clear problem, interface direction, reusable components, and admin-managed portfolio content without claiming measured business results.',
            ],
            'aruna-living' => [
                'category' => 'Property product concept',
                'client_name' => null,
                'summary' => 'Concept case study for a property discovery experience built around comparison, useful listing details, and clearer inquiry context.',
                'challenge' => 'The fictional brief assumes buyers struggle to compare listings because important decision information is scattered and filtering does not reflect how people narrow a shortlist.',
                'solution' => 'The concept prioritizes search filters, comparison, decision-ready listing details, and an inquiry handoff that carries the selected property context forward.',
                'result' => 'This case study demonstrates information hierarchy, comparison design, responsive listing patterns, and how a concept can be documented in the Laravel case-study model.',
            ],
            'flowdesk' => [
                'category' => 'Operations product concept',
                'client_name' => null,
                'summary' => 'Concept case study for an operations workspace that brings task status, approvals, and reporting into one predictable flow.',
                'challenge' => 'The fictional brief assumes work is split across spreadsheets and chat, making ownership, approval state, and handoff history difficult to trace.',
                'solution' => 'The concept defines role-aware views, approval states, a compact notification model, and reporting surfaces that keep operational status visible without overloading the dashboard.',
                'result' => 'This case study demonstrates workflow modelling, dashboard hierarchy, state design, and a maintainable content structure for documenting B2B product work.',
            ],
            'vanta-commerce' => [
                'category' => 'Commerce product concept',
                'client_name' => null,
                'summary' => 'Concept case study for a mobile-first storefront that balances product discovery, editorial content, and a simple checkout handoff.',
                'challenge' => 'The fictional brief assumes a catalogue is difficult to scan on mobile and the content hierarchy gives equal weight to too many competing messages.',
                'solution' => 'The concept narrows the hierarchy, improves browsing paths, keeps product information readable on small screens, and treats performance as part of the interface direction.',
                'result' => 'This case study demonstrates mobile-first hierarchy, commerce browsing patterns, content restraint, and the reusable project templates in this demo.',
            ],
        ];

        foreach ($projects as $slug => $project) {
            DB::table('projects')->where('slug', $slug)->update($project + [
                'metric' => null,
                'metric_label' => null,
                'is_concept' => true,
            ]);
        }

        DB::table('testimonials')
            ->whereIn('name', ['Adrian Raharja', 'Michelle Tan', 'Rizky Pratama'])
            ->update(['is_active' => false]);

        DB::table('services')->where('number', '01')->whereIn('title', ['Digital Product', 'Laravel application'])->update([
            'title' => 'Laravel application',
            'description' => 'Public Blade views backed by Eloquent models, route-model binding, form validation, and database-managed content.',
            'tags' => json_encode(['Laravel 9', 'Blade', 'Eloquent']),
        ]);
        DB::table('services')->where('number', '02')->whereIn('title', ['Brand Experience', 'Content management'])->update([
            'title' => 'Content management',
            'description' => 'Authenticated tools for projects, services, settings, verified testimonials, uploaded media, and contact messages.',
            'tags' => json_encode(['Admin CMS', 'Authentication', 'Uploads']),
        ]);
        DB::table('services')->where('number', '03')->whereIn('title', ['Business System', 'Production deployment'])->update([
            'title' => 'Production deployment',
            'description' => 'Dockerized Apache and PHP runtime with MySQL, migrations, health checks, security headers, rate limiting, and persistent media support.',
            'tags' => json_encode(['Docker', 'MySQL', 'Railway']),
        ]);
    }

    public function down(): void
    {
    }
};
