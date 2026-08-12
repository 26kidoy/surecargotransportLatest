<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Show the map page with locations.
     *
     * @return \Illuminate\View\View
     */
    public function showFind()
    {
        return view('find');
    }
}
