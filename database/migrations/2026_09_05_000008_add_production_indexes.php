<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->index(['is_published', 'is_featured', 'sort_order'], 'projects_public_listing_idx');
            $table->index(['category', 'is_published'], 'projects_category_idx');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'services_active_sort_idx');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'testimonials_active_sort_idx');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'contact_status_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('projects_public_listing_idx');
            $table->dropIndex('projects_category_idx');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('services_active_sort_idx');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex('testimonials_active_sort_idx');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex('contact_status_created_idx');
        });
    }
};
