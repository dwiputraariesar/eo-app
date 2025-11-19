<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua event, urutkan dari yang terbaru
        $events = Event::orderBy('created_at', 'desc')->get();

        return view('welcome', compact('events'));
    }
}