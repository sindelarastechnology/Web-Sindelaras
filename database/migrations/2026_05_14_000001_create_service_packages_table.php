<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('price_sale', 12, 2)->nullable();
            $table->string('price_unit')->default('/ project');
            $table->boolean('is_popular')->default(false);
            $table->json('features')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('maintenance')->nullable();
            $table->json('bonus')->nullable();
            $table->string('cta_text')->default('Pilih Paket');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
