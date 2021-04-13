<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with('category', 'organizer', 'performers', 'audiences')->inRandomOrder()->paginate(10);

        return view('home', compact('events'));
    }
}
