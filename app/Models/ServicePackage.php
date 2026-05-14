<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ServicePackage extends Model
{
    use HasSlug, SoftDeletes;

    protected $fillable = [
        'service_id', 'name', 'slug', 'short_description',
        'price', 'price_sale', 'price_unit', 'is_popular',
        'features', 'delivery_time', 'maintenance', 'bonus',
        'cta_text', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_sale' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'features' => 'array',
        'bonus' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['service_id', 'name'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getFinalPriceAttribute(): ?string
    {
        if ($this->price_sale && $this->price_sale < $this->price) {
            return 'Rp ' . number_format($this->price_sale, 0, ',', '.');
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getOriginalPriceFormattedAttribute(): ?string
    {
        if (!$this->price_sale || $this->price_sale >= $this->price) return null;
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->price_sale && $this->price_sale < $this->price;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (!$this->has_discount) return null;
        return round((1 - $this->price_sale / $this->price) * 100);
    }
}
