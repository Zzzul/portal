<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $events = Event::with('category', 'performers')
            ->orWhereHas('audiences', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->get();
        // echo json_encode($events);
        // die;

        return view('history-event', compact('events'));
    }
}
