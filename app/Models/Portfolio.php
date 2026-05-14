<?php

namespace App\Models;

use Database\Factories\PortfolioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Portfolio extends Model
{
    /** @use HasFactory<PortfolioFactory> */
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'client_name', 'client_industry',
        'short_description', 'description', 'thumbnail', 'gallery',
        'live_url', 'github_url', 'demo_url',
        'technologies', 'project_date', 'project_duration', 'project_type',
        'client_testimonial', 'client_photo', 'client_position',
        'is_active', 'is_featured', 'sort_order', 'views',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'views' => 'integer',
        'gallery' => 'array',
        'technologies' => 'array',
        'project_date' => 'date',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'portfolio_tag');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? \Storage::url($this->thumbnail)
            : asset('images/default-portfolio.svg');
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($path) => \Storage::url($path))
            ->toArray();
    }
}
