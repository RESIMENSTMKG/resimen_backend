<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneGateLink extends Model
{
    use HasFactory;

    protected $table = 'one_gate_links';
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'category',
        'badge',
        'type',
        'description',
        'url',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
        'created_at' => 'datetime',
    ];
}
