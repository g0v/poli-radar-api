<?php

namespace Api\Controllers;

use App\Event;
use App\Http\Requests;
use Illuminate\Http\Request;
// use Api\Requests\EventRequest;
use Api\Transformers\EventTransformer;

/**
 * @Resource('Events', uri='/events')
 */
class EventsController extends BaseController
{

    /**
     * Show all events
     *
     * Get a JSON representation of all the events
     * 
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(Event::all(), new EventTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        return Event::create($request->only([
            'date',
            'start',
            'end',
            'name',
            'location',
            'addr',
            'latitude',
            'longitude',
            'type_id'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(Event::findOrFail($id));
    }

    /**
     * Update the Event in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->only([
            'date',
            'start',
            'end',
            'name',
            'location',
            'addr',
            'latitude',
            'longitude',
            'type_id'
        ]));
        return $event;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Event::destroy($id);
    }
}
