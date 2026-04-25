<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address', 'country', 'city', 'user_agent',
        'device_type', 'browser', 'platform',
        'url', 'locale', 'referrer', 'is_unique',
    ];

    protected $casts = ['is_unique' => 'boolean'];

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeUniqueToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today())->where('is_unique', true);
    }
}
