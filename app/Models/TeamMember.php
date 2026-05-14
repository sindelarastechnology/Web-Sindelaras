<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'position', 'photo', 'bio', 'skills',
        'instagram', 'linkedin', 'github', 'email',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? \Storage::url($this->photo)
            : asset('images/default-avatar.svg');
    }
}
