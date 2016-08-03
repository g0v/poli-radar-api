<?php

namespace Api\V2\Controllers;

use App\Event;
use Api\V2\Transformers\EventTransformer;

/**
 * @Resource('Events', uri='/events')
 */
class EventsController extends BaseController
{
    /**
     * Show all events
     *
     * Get a JSON representation of all the politicians
     *
     * @Get('/events')
     */
    public function index()
    {
        return $this->response->collection(Event::all(), new EventTransformer);
    }

    /**
     * Store a new event in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    // }

    /**
     * Update the Event in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    // }
}
