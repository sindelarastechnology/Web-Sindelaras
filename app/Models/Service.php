<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'short_description', 'description',
        'icon', 'image', 'banner_image',
        'show_price', 'price_from', 'price_to', 'price_unit',
        'features', 'process_steps',
        'cta_text', 'cta_link', 'whatsapp_template',
        'is_active', 'is_featured', 'sort_order',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $casts = [
        'show_price' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2',
        'features' => 'array',
        'process_steps' => 'array',
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

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(ServicePackage::class)->orderBy('sort_order');
    }

    public function activePackages(): HasMany
    {
        return $this->hasMany(ServicePackage::class)->active()->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? \Storage::url($this->image)
            : asset('images/default-service.svg');
    }

    public function getPriceRangeAttribute(): ?string
    {
        if (!$this->show_price) return null;
        $from = (float) ($this->price_from ?? 0);
        $to = (float) ($this->price_to ?? 0);
        if ($from > 0 && $to > 0) {
            return formatRupiah($from) . ' – ' . formatRupiah($to);
        }
        return $from > 0 ? 'Mulai ' . formatRupiah($from) : null;
    }

    public function getWhatsappUrlAttribute(): string
    {
        $msg = 'Halo, saya ingin konsultasi mengenai layanan ' . $this->title;
        return whatsappLink(site_whatsapp(), $msg);
    }
}
