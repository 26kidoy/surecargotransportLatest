<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminHelper
{
    /**
     * Safely get model count with caching
     */
    public static function safeCount($modelClass, $cacheKey, $minutes = 5)
    {
        try {
            if (!class_exists($modelClass)) {
                return 0;
            }

            return Cache::remember($cacheKey, $minutes, function() use ($modelClass) {
                return $modelClass::count();
            });
        } catch (\Exception $e) {
            Log::warning("Failed to count {$modelClass}: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Check if admin is authenticated and active
     */
    public static function isAdminAuthenticated()
    {
        if (!auth()->guard('admin')->check()) {
            return false;
        }

        $admin = auth()->guard('admin')->user();
        return $admin && $admin->is_active;
    }
}
