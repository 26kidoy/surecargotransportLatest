<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Announcement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'image',
        'is_published',
        'published_at',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the user who created this announcement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include published announcements.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Get the full URL for the announcement image
     * FIXED: Properly handles public/uploads paths with multiple fallbacks
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }

        $path = $this->image;

        // If it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Clean the path
        $path = preg_replace('/^(storage\/|public\/)/', '', $path);

        // If path starts with 'announcements/', convert to 'uploads/announcements/'
        if (Str::startsWith($path, 'announcements/')) {
            $path = 'uploads/' . $path;
        }

        // If path doesn't start with 'uploads/', add it
        if (!Str::startsWith($path, 'uploads/')) {
            $path = 'uploads/' . $path;
        }

        // Check if file exists in public/uploads
        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            return asset($path);
        }

        // Try removing 'uploads/' prefix and check storage
        $storagePath = preg_replace('/^uploads\//', '', $path);
        if (Storage::disk('public')->exists($storagePath)) {
            return asset('storage/' . $storagePath);
        }

        // Try checking just the filename in uploads
        $filename = basename($path);
        $searchPaths = [
            'uploads/announcements/' . date('Y/m/d') . '/' . $filename,
            'uploads/announcements/' . $filename,
            'uploads/' . $filename,
        ];

        foreach ($searchPaths as $searchPath) {
            if (file_exists(public_path($searchPath))) {
                return asset($searchPath);
            }
        }

        // Try storage paths as fallback
        $storagePaths = [
            'announcements/' . date('Y/m/d') . '/' . $filename,
            'announcements/' . $filename,
            $filename,
        ];

        foreach ($storagePaths as $storagePath) {
            if (Storage::disk('public')->exists($storagePath)) {
                return asset('storage/' . $storagePath);
            }
        }

        // If all else fails, return null
        return null;
    }

    /**
     * Delete the image file when the model is deleted.
     * FIXED: Properly deletes from public/uploads
     */
    protected static function booted()
    {
        static::deleting(function ($announcement) {
            if ($announcement->image) {
                $path = $announcement->image;

                // Try to delete from public/uploads
                if (Str::startsWith($path, 'uploads/')) {
                    $fullPath = public_path($path);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                        \Log::info('Deleted announcement image from public/uploads', ['path' => $path]);
                        return;
                    }
                }

                // Try to delete from storage
                $cleanPath = preg_replace('/^(uploads\/|storage\/|public\/)/', '', $path);
                if (Storage::disk('public')->exists($cleanPath)) {
                    Storage::disk('public')->delete($cleanPath);
                    \Log::info('Deleted announcement image from storage', ['path' => $cleanPath]);
                    return;
                }

                // Try to delete just the filename
                $filename = basename($path);
                $searchPaths = [
                    'uploads/announcements/' . date('Y/m/d') . '/' . $filename,
                    'uploads/announcements/' . $filename,
                    'uploads/' . $filename,
                    'announcements/' . date('Y/m/d') . '/' . $filename,
                    'announcements/' . $filename,
                ];

                foreach ($searchPaths as $searchPath) {
                    if (file_exists(public_path($searchPath))) {
                        unlink(public_path($searchPath));
                        \Log::info('Deleted announcement image from public/uploads (search)', ['path' => $searchPath]);
                        return;
                    }
                    if (Storage::disk('public')->exists($searchPath)) {
                        Storage::disk('public')->delete($searchPath);
                        \Log::info('Deleted announcement image from storage (search)', ['path' => $searchPath]);
                        return;
                    }
                }
            }
        });
    }
}
