<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Display the chatbot page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('chatbot');
    }
}
