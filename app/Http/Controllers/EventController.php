<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
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

    public function bookEvent($slug)
    {
        $event = Event::with('category', 'performers', 'audiences')->where('slug', $slug)->firstOrFail();

        if ($event->user_id == auth()->id())
            return redirect()->back()->with('error', 'Can`t book event cause is your event.');

        // if max audience full
        if ($event->max_audience === count($event['audiences']))
            return redirect()->back()->with('error', 'Can`t book event cause audiences is full.');

        if (date('Y-m-d H:i', strtotime($event->start_time)) < date('Y-m-d H:i'))
            return redirect()->back()->with('error', 'Can`t book event cause event is already started/ended.');

        try {

            $event->audiences()->attach(['user_id' => auth()->id()], [
                // insert additional data for pivot table
                'transaction_code' => Str::random(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Book event successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'You`re already book for this event.');
        }
    }
}
