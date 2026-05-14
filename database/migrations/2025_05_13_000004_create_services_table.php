<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('language', 10)->default('id');

            $table->boolean('show_price')->default(false);
            $table->decimal('price_from', 12, 2)->nullable();
            $table->decimal('price_to', 12, 2)->nullable();
            $table->string('price_unit')->nullable();

            $table->json('features')->nullable();
            $table->json('process_steps')->nullable();
            $table->json('faqs')->nullable();

            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();
            $table->string('whatsapp_template')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
