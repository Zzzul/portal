<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index()
    {
        $events = Event::with('category', 'performers', 'history')
            ->whereHas('audiences', function ($q) {
                $q->where('audience_event.user_id', auth()->id());
            })
            ->get();

        // echo json_encode($events);
        // die;

        return view('history-event', compact('events'));
    }

    public function detailEvent($slug)
    {
        $event = Event::with('category', 'performers', 'audiences')->where('slug', $slug)->firstOrFail();

        return view('detail-event', compact('event'));
    }
}
