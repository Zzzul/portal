<?php

namespace App\Http\Controllers;

use App\Http\Requests\Performer\StorePerformerRequest;
use App\Http\Requests\Performer\UpdatePerformerRequest;
use App\Models\Performer;
use Illuminate\Http\Request;

class PerformerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $performers = Performer::where('user_id', auth()->id())->paginate(10);

        return view('performers.index', compact('performers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('performers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerformerRequest $request)
    {
        $performer = $request->validated();
        $performer['user_id'] = auth()->id();

        Performer::create($performer);

        return redirect()->route('performer.index')->with('success', 'Performer created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $performer = Performer::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        return view('performers.edit', compact('performer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerformerRequest $request, $id)
    {
        Performer::where('id', $id)->where('user_id', auth()->id())->firstOrFail()->update($request->validated());

        return redirect()->route('performer.index')->with('success', 'Performer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // delete with modal
    public function destroy()
    {
        $performer = Performer::where('id', request('id'))->where('user_id', auth()->id())->firstOrFail();

        try {
            $performer->delete();

            return redirect()->route('performer.index')->with('success', 'Performer deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->route('performer.index')->with('error', 'Can`t delete performer!');
        }
    }
}
