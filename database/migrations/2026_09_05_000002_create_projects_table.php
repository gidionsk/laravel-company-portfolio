<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->text('summary');
            $table->longText('challenge')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('result')->nullable();
            $table->string('metric', 50)->nullable();
            $table->string('metric_label')->nullable();
            $table->json('tags')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('theme', 30)->default('indigo');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
