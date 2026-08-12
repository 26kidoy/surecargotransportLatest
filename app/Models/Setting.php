<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description'
    ];

    protected $casts = [
        'value' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get setting value with type casting
     *
     * @param string $key
     * @param mixed $default
     * @param bool $fresh Force fresh retrieval bypassing cache
     * @return mixed
     */
    public static function getValue(string $key, $default = null, bool $fresh = false)
    {
        $cacheKey = 'setting_' . $key;

        // If fresh is requested, bypass cache
        if ($fresh) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, 3600, function() use ($key, $default) {
            $setting = static::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'integer' => (int) $setting->value,
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'json' => json_decode($setting->value, true),
                'float' => (float) $setting->value,
                default => $setting->value,
            };
        });
    }

    /**
     * Set setting value and clear cache
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string $group
     * @param string|null $description
     * @return Model
     */
    public static function setValue(string $key, $value, string $type = 'string', string $group = 'general', ?string $description = null)
    {
        $stringValue = is_array($value) ? json_encode($value) : (string) $value;

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
                'group' => $group,
                'description' => $description
            ]
        );

        // Clear cache for this key
        Cache::forget('setting_' . $key);

        // Clear the grouped settings cache as well
        Cache::forget('settings_all_grouped');

        return $setting;
    }

    /**
     * Get all settings grouped by group
     *
     * @param bool $fresh Force fresh retrieval bypassing cache
     * @return array
     */
    public static function getAllGrouped(bool $fresh = false): array
    {
        $cacheKey = 'settings_all_grouped';

        if ($fresh) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, 3600, function() {
            $settings = static::all();
            $grouped = [];

            foreach ($settings as $setting) {
                if (!isset($grouped[$setting->group])) {
                    $grouped[$setting->group] = [];
                }
                $grouped[$setting->group][$setting->key] = self::getValue($setting->key);
            }

            return $grouped;
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget('setting_' . $setting->key);
        }
        Cache::forget('settings_all_grouped');
    }

    /**
     * Get a setting value without caching (forces fresh DB query)
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValueFresh(string $key, $default = null)
    {
        return self::getValue($key, $default, true);
    }

    /**
     * Check if a setting exists by key
     *
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return static::where('key', $key)->exists();
    }

    /**
     * Delete a setting by key and clear cache
     *
     * @param string $key
     * @return bool
     */
    public static function deleteValue(string $key): bool
    {
        $deleted = static::where('key', $key)->delete();

        if ($deleted) {
            Cache::forget('setting_' . $key);
            Cache::forget('settings_all_grouped');
        }

        return $deleted;
    }
}
