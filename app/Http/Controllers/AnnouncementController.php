<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of published announcements.
     */
    public function index()
    {
        $announcements = Announcement::published()
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Display the specified published announcement.
     */
    public function show(Announcement $announcement)
    {
        // Ensure only published announcements are viewable
        if (!$announcement->is_published || $announcement->published_at > now()) {
            abort(404);
        }

        return view('announcements.show', compact('announcement'));
    }
}
