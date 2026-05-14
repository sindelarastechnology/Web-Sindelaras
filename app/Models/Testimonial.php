<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'portfolio_id', 'service_id', 'client_name', 'client_position', 'client_company',
        'client_photo', 'client_location', 'content', 'rating',
        'service_used', 'source', 'is_active', 'is_featured', 'sort_order',
        'video_url',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->client_photo
            ? \Storage::url($this->client_photo)
            : asset('images/default-avatar.svg');
    }

    public function getStarsAttribute(): array
    {
        return array_fill(0, $this->rating ?? 5, '★');
    }
}
