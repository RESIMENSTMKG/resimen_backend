<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $table = 'committees';
    const UPDATED_AT = null;

    protected $fillable = [
        'division',
        'name',
        'role',
        'major',
        'photo_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
