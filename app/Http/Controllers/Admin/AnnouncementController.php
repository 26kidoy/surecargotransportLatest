<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement in storage.
     * FIXED: Now saves to public/uploads/announcements/
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published'  => 'nullable|boolean',
            'published_at'  => 'nullable|date',
        ]);

        // Handle image upload - FIXED: Save to public/uploads
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $datePath = date('Y/m/d');
            $relativePath = "announcements/{$datePath}";
            $fullPath = public_path("uploads/{$relativePath}");

            try {
                // Create directory if it doesn't exist
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }

                // Move file to public/uploads directory
                $file->move($fullPath, $filename);

                // Store the path relative to public directory
                $validated['image'] = "uploads/{$relativePath}/{$filename}";

                Log::info('Announcement image uploaded to public/uploads', [
                    'path' => $validated['image'],
                    'user_id' => auth()->id()
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to upload announcement image: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Failed to upload image. Please check folder permissions.')
                    ->withInput();
            }
        }

        $validated['is_published'] = $validated['is_published'] ?? false;
        $validated['published_at'] = $validated['published_at'] ?? ($validated['is_published'] ? now() : null);

        $announcement = Announcement::create($validated);

        // Send notification if published and publish date is not in the future
        if ($announcement->is_published && $announcement->published_at <= now()) {
            NotificationHelper::sendAnnouncementNotification($announcement, 'created');
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement in storage.
     * FIXED: Now saves to public/uploads/announcements/
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published'  => 'nullable|boolean',
            'published_at'  => 'nullable|date',
        ]);

        // Handle image upload - FIXED: Save to public/uploads
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image) {
                $this->deleteAnnouncementImage($announcement->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $datePath = date('Y/m/d');
            $relativePath = "announcements/{$datePath}";
            $fullPath = public_path("uploads/{$relativePath}");

            try {
                // Create directory if it doesn't exist
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }

                // Move file to public/uploads directory
                $file->move($fullPath, $filename);

                // Store the path relative to public directory
                $validated['image'] = "uploads/{$relativePath}/{$filename}";

                Log::info('Announcement image updated in public/uploads', [
                    'path' => $validated['image'],
                    'user_id' => auth()->id()
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to update announcement image: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Failed to upload image. Please check folder permissions.')
                    ->withInput();
            }
        }

        $validated['is_published'] = $validated['is_published'] ?? false;
        $validated['published_at'] = $validated['published_at'] ?? ($validated['is_published'] ? now() : null);

        // Check if it was published before update
        $wasPublished = $announcement->is_published && $announcement->published_at <= now();

        $announcement->update($validated);

        // Check if it is published after update
        $isPublished = $announcement->is_published && $announcement->published_at <= now();

        // Send notification only if it is published now
        // (either it became published now, or it was already published and got updated)
        if ($isPublished) {
            NotificationHelper::sendAnnouncementNotification($announcement, 'updated');
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement from storage.
     * FIXED: Properly deletes from public/uploads
     */
    public function destroy(Announcement $announcement)
    {
        // Delete image if exists
        if ($announcement->image) {
            $this->deleteAnnouncementImage($announcement->image);
        }
        $announcement->delete();

        Log::info('Announcement deleted', [
            'announcement_id' => $announcement->id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Helper: Delete announcement image from public/uploads
     */
    private function deleteAnnouncementImage($path)
    {
        if (empty($path)) {
            return;
        }

        try {
            // Check if it's a public/uploads path
            if (Str::startsWith($path, 'uploads/')) {
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    Log::info('Deleted announcement image from public/uploads', ['path' => $path]);
                    return;
                }
            }

            // Check if it's a storage path (old format)
            $cleanPath = preg_replace('/^(storage\/|public\/)/', '', $path);
            if (Storage::disk('public')->exists($cleanPath)) {
                Storage::disk('public')->delete($cleanPath);
                Log::info('Deleted announcement image from storage', ['path' => $cleanPath]);
                return;
            }

            // Try to delete just the filename (search in common locations)
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
                    Log::info('Deleted announcement image from public/uploads (search)', ['path' => $searchPath]);
                    return;
                }
                if (Storage::disk('public')->exists($searchPath)) {
                    Storage::disk('public')->delete($searchPath);
                    Log::info('Deleted announcement image from storage (search)', ['path' => $searchPath]);
                    return;
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete announcement image: ' . $e->getMessage(), ['path' => $path]);
        }
    }
}
