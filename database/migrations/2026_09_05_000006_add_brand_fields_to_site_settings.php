<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('hero_badge')->nullable()->after('tagline');
            $table->string('accent_color', 7)->default('#7357ff')->after('hero_description');
            $table->string('accent_color_secondary', 7)->default('#29d3b2')->after('accent_color');
            $table->string('cta_label')->nullable()->after('accent_color_secondary');
            $table->string('cta_url')->nullable()->after('cta_label');
            $table->string('seo_title')->nullable()->after('instagram_url');
            $table->text('seo_description')->nullable()->after('seo_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_badge',
                'accent_color',
                'accent_color_secondary',
                'cta_label',
                'cta_url',
                'seo_title',
                'seo_description',
            ]);
        });
    }
};
