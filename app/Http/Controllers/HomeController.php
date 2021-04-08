<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with('category', 'organizer', 'performers', 'audiences')->inRandomOrder()->paginate(10);
        // echo json_encode($events);
        // die;
        return view('home', compact('events'));
    }
}
