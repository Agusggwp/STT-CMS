<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
    ];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("site_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value, string $group = 'general', string $type = 'text', ?string $label = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget("site_setting_{$key}");
        Cache::forget('site_settings_all');
        Cache::forget('site_settings_map');

        return $setting;
    }

    public static function getAllGrouped(): array
    {
        return Cache::rememberForever('site_settings_all', function () {
            return static::all()->groupBy('group')->map(function ($items) {
                return $items->pluck('value', 'key');
            })->toArray();
        });
    }

    public static function getAllMap(): array
    {
        return Cache::rememberForever('site_settings_map', function () {
            return static::all()->pluck('value', 'key')->toArray();
        });
    }
}
