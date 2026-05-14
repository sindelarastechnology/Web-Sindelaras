<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page_key', 'title', 'subtitle', 'content', 'banner_image',
        'extra_data', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public static function get(string $key): ?self
    {
        return cache()->remember("page_content_{$key}", 3600, function () use ($key) {
            return static::where('page_key', $key)->first();
        });
    }
}
