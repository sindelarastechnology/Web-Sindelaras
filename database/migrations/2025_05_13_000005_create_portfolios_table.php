<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client_name')->nullable();
            $table->string('client_industry')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->string('language', 10)->default('id');

            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();

            $table->json('technologies')->nullable();

            $table->date('project_date')->nullable();
            $table->string('project_duration')->nullable();
            $table->enum('project_type', ['website', 'aplikasi_web', 'android', 'desktop', 'data', 'lainnya'])->default('website');

            $table->string('client_testimonial')->nullable();
            $table->string('client_photo')->nullable();
            $table->string('client_position')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->integer('views')->default(0);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
