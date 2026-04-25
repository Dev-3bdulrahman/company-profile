<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseCache extends Model
{
    protected $table = 'license_cache';

    protected $fillable = [
        'license_key',
        'status',
        'restriction_mode',
        'show_licensing_ui',
        'payload_json',
        'signature',
        'last_verified_at',
        'expires_at',
        'grace_until',
    ];

    protected $casts = [
        'payload_json' => 'array',
        'last_verified_at' => 'datetime',
        'expires_at' => 'datetime',
        'grace_until' => 'datetime',
        'show_licensing_ui' => 'boolean',
    ];
}
