<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'excerpt', 'content',
        'featured_image', 'featured_image_alt',
        'status', 'published_at', 'is_featured', 'allow_comments',
        'views', 'read_time',
        'meta_title', 'meta_description', 'meta_keywords',
        'canonical_url', 'schema_markup',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'views' => 'integer',
        'read_time' => 'integer',
        'published_at' => 'datetime',
        'schema_markup' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function getReadingTimeAttribute(): string
    {
        $text = strip_tags($this->content ?? '');
        $words = preg_match_all('/\p{L}+/u', $text) ?: 0;
        $minutes = max(1, ceil($words / 200));
        return $minutes . ' menit baca';
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->featured_image
            ? \Storage::url($this->featured_image)
            : asset('images/default-post.svg');
    }
}
