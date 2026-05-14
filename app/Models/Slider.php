<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'mobile_image',
        'button_text', 'button_link', 'button_text_2', 'button_link_2',
        'text_color', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? \Storage::url($this->image) : '';
    }
}
