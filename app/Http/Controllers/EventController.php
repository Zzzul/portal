<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\Performer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::with('category', 'performers', 'audiences')->where('user_id', auth()->id())->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $performers = Performer::where('user_id', auth()->id())->get();
        return view('events.create', compact('categories', 'performers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $attr = $request->validated();
        $attr['slug'] = Str::slug($attr['title']);
        $attr['user_id'] = auth()->id();

        $event = Event::create($attr);
        $event->performers()->attach($request->performer_id);

        return redirect()->route('event.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::with('category', 'performers', 'audiences')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::get();

        $event = Event::with('category', 'performers')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $performers_id = [];
        foreach ($event->performers as $performer) {
            $performers_id[] = $performer->id;
        }

        $not_event_performers = Performer::whereNotIn('id', $performers_id)->get();

        return view('events.edit', compact('categories', 'event', 'not_event_performers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, $id)
    {
        $attr = $request->validated();
        $attr['slug'] = Str::slug($attr['title']);

        $event = Event::with('category', 'performers')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $event->update($attr);

        $event->performers()->sync($request->performer_id);

        return redirect()->route('event.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $event = Event::where('id', request()->id)->where('user_id', auth()->id())->firstOrFail();

        try {
            $event->delete();

            return redirect()->route('event.index')->with('success', 'Event deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->route('event.index')->with('error', 'Can`t delete event!');
        }
    }

    public function registerEvent($slug)
    {
        $event = Event::with('category', 'performers', 'audiences')->where('slug', $slug)->firstOrFail();

        if ($event->user_id == auth()->id()) return redirect()->route('home')->with('error', 'Can`t register event cause is your event!');

        $register = [
            'transaction_code' => Str::random(15),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        try {
            $event->audiences()->attach(['user_id' => auth()->id()], $register);

            return redirect()->route('home')->with('success', 'Registered event successfully!');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'You`re already registered for this event!');
        }
    }

    public function updatePayment($transaction_code)
    {

        $event = DB::table('audience_event')->where('transaction_code', $transaction_code)->first();
        $payment_status = DB::table('audience_event')->where('transaction_code', $transaction_code)->limit(1);

        if ($event->payment_status == 0) {
            $payment_status->update(['payment_status' => 1]);
        } else {
            $payment_status->update(['payment_status' => 0]);
        }

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    public function checkPaymentStatus()
    {

        $event = DB::table('audience_event')->where('transaction_code', request()->get('transaction_code'))->first();

        return view('events.check-payment-status', compact('event'));
    }
}
