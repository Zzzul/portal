<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\Performer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:event index')->only('index');
        $this->middleware('permission:event create')->only('create');
        $this->middleware('permission:event show')->only('show');
        $this->middleware('permission:event edit')->only('edit');
        $this->middleware('permission:event update')->only('update');
    }

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

        if ($request->file('thumbnail')->isValid()) {
            $filename = $attr['slug']  . '.' . $request->thumbnail->extension();

            $request->thumbnail->storeAs('public/images/thumbnail/', $filename);

            $attr['thumbnail'] = $filename;
        }

        $event = Event::create($attr);
        $event->performers()->attach($request->performer_id);

        return redirect()->route('event.index')->with('success', 'Event created successfully.');
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

        $not_event_performers = Performer::where('user_id', auth()->id())->whereNotIn('id', $performers_id)->get();

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
        $event = Event::with('category', 'performers')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $attr = $request->validated();
        $attr['slug'] = Str::slug($attr['title']);

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {
            // remove old file
            Storage::delete('public/images/thumbnail/' . $event->thumbnail);

            $filename = $attr['slug'] . '.' . $request->thumbnail->extension();

            $request->thumbnail->storeAs('public/images/thumbnail/', $filename);

            $attr['thumbnail'] = $filename;
        }

        $event->update($attr);

        $event->performers()->sync($request->performer_id);

        return redirect()->route('event.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $event = Event::with('audiences', 'performers')->where(['id' => request()->id, 'user_id' => auth()->id()])->firstOrFail();

        // if empty regisrered audiences
        if ($event->audiences->isEmpty()) {
            // detach all event_performers, so can delete event
            $event->performers()->detach($event->performers);

            try {
                Storage::delete('public/images/thumbnail/' . $event->thumbnail);
                $event->delete();

                return redirect()->route('event.index')->with('success', 'Event deleted successfully.');
            } catch (\Exception $ex) {
                return redirect()->route('event.index')->with('error', 'Can`t delete event.');
            }
        } else {
            return redirect()->route('event.index')->with('error', 'Can`t delete event.');
        }
    }

    public function updatePaymentStatus($transaction_code)
    {
        $event = DB::table('audience_event')->where('transaction_code', $transaction_code)->first();
        $payment_status = DB::table('audience_event')->where('transaction_code', $transaction_code)->limit(1);

        if ($event->payment_status == 0) {
            $payment_status->update(['payment_status' => 1, 'updated_at' => Carbon::now(),]);
        } else {
            $payment_status->update(['payment_status' => 0, 'updated_at' => Carbon::now(),]);
        }

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }

    public function checkPaymentStatus()
    {
        $event = Event::with(['audiences' => function ($q) {
            $q->where('transaction_code', request()->get('transaction_code'));
        }])->where('user_id', auth()->id())->first();

        // echo json_encode($event);
        // die;

        return view('events.check-payment-status', compact('event'));
    }
}
