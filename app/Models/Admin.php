<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    public $incrementing = false;
    protected $keyType = 'string';
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password_hash',
        'role',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected static function booted(): void
    {
        static::creating(function ($admin) {
            if (empty($admin->id)) {
                $admin->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get password for authentication.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }
}
