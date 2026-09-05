<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('category');
            $table->unsignedSmallInteger('project_year')->nullable()->after('client_name');
            $table->string('project_url')->nullable()->after('project_year');
            $table->json('gallery_images')->nullable()->after('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'project_year', 'project_url', 'gallery_images']);
        });
    }
};
