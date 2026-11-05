<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'category',
        'event_date',
        'location',
        'summary',
        'description',
        'template_type',
        'cover_photo_url',
        'photos',
    ];

    protected $casts = [
        'event_date' => 'date:Y-m-d',
        'photos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
