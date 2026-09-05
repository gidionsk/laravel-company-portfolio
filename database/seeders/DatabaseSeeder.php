<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = config('portfolio.admin_email');
        $adminPassword = config('portfolio.admin_password');

        if (app()->environment('production') && (! $adminEmail || ! $adminPassword)) {
            throw new \RuntimeException('ADMIN_EMAIL dan ADMIN_PASSWORD wajib diisi sebelum menjalankan seeder di production.');
        }

        $adminEmail ??= 'admin@northstar.test';
        $adminPassword ??= 'password';

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Portfolio Admin',
                'password' => Hash::make($adminPassword),
            ]
        );

        if (! config('portfolio.seed_demo')) {
            return;
        }

        SiteSetting::updateOrCreate(['id' => 1], [
            'company_name' => 'Northstar Studio',
            'company_short_name' => 'NORTHSTAR',
            'tagline' => 'Digital Product Company',
            'hero_badge' => 'Available for selected projects',
            'hero_title' => 'We build digital experiences that',
            'hero_highlight' => 'move business.',
            'hero_description' => 'Strategy, design, and technology in one team. We turn complex ideas into digital products people actually enjoy using.',
            'accent_color' => '#7357ff',
            'accent_color_secondary' => '#29d3b2',
            'cta_label' => 'Start a project',
            'cta_url' => '#contact',
            'seo_title' => 'Northstar — Digital Product Company',
            'seo_description' => 'Strategy, design, and engineering for ambitious digital products and business systems.',
            'email' => 'hello@northstar.co',
            'phone' => '+62 812 3456 7890',
            'whatsapp' => '6281234567890',
            'location' => 'Surabaya, Indonesia',
        ]);

        $services = [
            [
                'number' => '01',
                'title' => 'Digital Product',
                'description' => 'Web dan mobile experience yang cepat, intuitif, dan dirancang untuk mendukung pertumbuhan bisnis.',
                'tags' => ['Web Development', 'Mobile App', 'UI Engineering'],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'number' => '02',
                'title' => 'Brand Experience',
                'description' => 'Membangun identitas digital yang konsisten agar brand mudah dikenali, dipercaya, dan terasa premium.',
                'tags' => ['Brand Direction', 'Design System', 'UI/UX'],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'number' => '03',
                'title' => 'Business System',
                'description' => 'Sistem internal dan dashboard yang menyatukan workflow, approval, reporting, dan integrasi API.',
                'tags' => ['Dashboard', 'Automation', 'API Integration'],
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }

        $projects = [
            [
                'title' => 'Nexa Finance',
                'slug' => 'nexa-finance',
                'category' => 'Fintech Platform',
                'client_name' => 'Nexa',
                'project_year' => 2026,
                'summary' => 'Modernisasi pengalaman transaksi digital untuk mempercepat proses dan meningkatkan kepercayaan pengguna.',
                'challenge' => 'User harus melewati terlalu banyak langkah untuk menyelesaikan transaksi dan tim produk kesulitan melihat titik drop-off utama.',
                'solution' => 'Kami menyederhanakan journey, membangun ulang design system, dan merancang dashboard performa agar tim dapat mengambil keputusan lebih cepat.',
                'result' => 'Alur utama menjadi lebih pendek, konsistensi UI meningkat, dan funnel transaksi menjadi lebih mudah diukur.',
                'metric' => '+42%',
                'metric_label' => 'conversion rate',
                'tags' => ['Product Strategy', 'UI/UX', 'Laravel', 'Analytics'],
                'theme' => 'indigo',
                'sort_order' => 1,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Aruna Living',
                'slug' => 'aruna-living',
                'category' => 'Property Platform',
                'client_name' => 'Aruna Group',
                'project_year' => 2026,
                'summary' => 'Platform property discovery yang membantu calon pembeli menemukan listing yang relevan dengan lebih cepat.',
                'challenge' => 'Listing banyak tetapi sulit dibandingkan, informasi penting tersebar, dan inquiry berkualitas rendah.',
                'solution' => 'Kami merancang search experience, comparison flow, dan detail listing yang memprioritaskan informasi keputusan pembelian.',
                'result' => 'Calon pembeli dapat menyaring pilihan dengan lebih cepat dan tim sales menerima lead dengan konteks yang lebih lengkap.',
                'metric' => '2.4x',
                'metric_label' => 'more qualified leads',
                'tags' => ['UX Research', 'Web App', 'CRM Integration'],
                'theme' => 'sand',
                'sort_order' => 2,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'FlowDesk',
                'slug' => 'flowdesk',
                'category' => 'B2B Operations',
                'client_name' => 'FlowDesk',
                'project_year' => 2026,
                'summary' => 'Dashboard operasional yang menyatukan workflow tim, approval, dan reporting dalam satu tempat.',
                'challenge' => 'Tim bekerja dari spreadsheet dan chat yang berbeda sehingga status pekerjaan sulit dilacak dan approval sering terlambat.',
                'solution' => 'Kami membuat dashboard role-based, approval pipeline, notification center, dan reporting yang bisa diekspor.',
                'result' => 'Pekerjaan manual berkurang, visibility meningkat, dan koordinasi antar tim menjadi lebih konsisten.',
                'metric' => '-31%',
                'metric_label' => 'manual processing',
                'tags' => ['Dashboard', 'Workflow', 'API', 'Automation'],
                'theme' => 'mint',
                'sort_order' => 3,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Vanta Commerce',
                'slug' => 'vanta-commerce',
                'category' => 'Commerce Experience',
                'client_name' => 'Vanta',
                'project_year' => 2025,
                'summary' => 'Rebuild storefront untuk brand lifestyle dengan fokus pada storytelling, kecepatan, dan conversion.',
                'challenge' => 'Website lama lambat dan katalog sulit dieksplorasi terutama dari mobile.',
                'solution' => 'Kami mengoptimalkan struktur konten, product discovery, dan checkout handoff dengan pendekatan mobile-first.',
                'result' => 'Page experience terasa lebih ringan dan produk utama lebih mudah ditemukan dari halaman landing.',
                'metric' => '1.8s',
                'metric_label' => 'faster page load',
                'tags' => ['E-commerce', 'Performance', 'Responsive Web'],
                'theme' => 'coral',
                'sort_order' => 4,
                'is_featured' => false,
                'is_published' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }

        Testimonial::updateOrCreate(['name' => 'Adrian Raharja'], [
            'role' => 'Product Director',
            'company' => 'Aruna Group',
            'quote' => 'Northstar tidak hanya redesign produk kami. Mereka membantu menyederhanakan cara bisnis melihat keseluruhan customer experience.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Testimonial::updateOrCreate(['name' => 'Michelle Tan'], [
            'role' => 'Head of Digital',
            'company' => 'Vanta Commerce',
            'quote' => 'The team moved quickly without making the process feel rushed. Every decision had a clear reason behind it.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Testimonial::updateOrCreate(['name' => 'Rizky Pratama'], [
            'role' => 'Operations Lead',
            'company' => 'FlowDesk',
            'quote' => 'Kami akhirnya punya sistem yang terasa dibuat untuk workflow tim kami, bukan sekadar memindahkan spreadsheet ke browser.',
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}
