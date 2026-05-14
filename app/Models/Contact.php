<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'company', 'subject', 'message',
        'service_id', 'status', 'admin_notes', 'replied_by', 'replied_at',
        'source', 'ip_address', 'user_agent', 'referrer',
        'budget', 'timeline',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
