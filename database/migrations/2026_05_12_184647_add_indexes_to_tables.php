<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
            $table->index('is_featured');
        });
        Schema::table('portfolios', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
            $table->index('is_featured');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
            $table->index('is_featured');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->index('type');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });
        Schema::table('team_members', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });
        Schema::table('achievements', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
            $table->dropIndex(['is_featured']);
        });
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
            $table->dropIndex(['is_featured']);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['is_featured']);
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['type']);
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });
    }
};
