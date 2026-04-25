<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class HomeSection extends Model
{
    use HasTranslations;

    protected $fillable = ['key', 'content', 'is_active', 'sort_order'];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public $translatable = ['content'];

    public static function getSection(string $key, $default = null)
    {
        $section = self::where('key', $key)->where('is_active', true)->first();
        
        if (!$section) return $default;

        $content = $section->content;
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        if (is_array($content)) {
            $result = [];
            foreach ($content as $k => $v) {
                if (is_array($v) && isset($v[$locale])) {
                    $result[$k] = $v[$locale] ?? $v[$fallback] ?? reset($v);
                } else {
                    $result[$k] = $v;
                }
            }
            return $result;
        }

        return $content;
    }
}
