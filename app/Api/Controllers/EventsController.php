<?php

namespace Api\Controllers;

use App\Event;
use App\Http\Requests;
use Illuminate\Http\Request;
// use Api\Requests\EventRequest;
use Api\Transformers\EventTransformer;
use Carbon\Carbon;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

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
    public function index($start = null, $end = null)
    {
        $fractal = new Manager();

        if(is_null($end)) {
            $end = Carbon::now();
        } else {
            $end = Carbon::parse($end);
        }

        if(is_null($start)) {
            $start = Carbon::now()->subDays(7);
        } else {
            $start = Carbon::parse($start);
        }

        $events = new FractalCollection(Event::whereBetween('date', [$start, $end])->get(), new EventTransformer);

        return $this->array([
            'events' => $fractal->createData($events)->toArray(),
            'date' => [
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = Event::create($request->only([
            'date',
            'start',
            'end',
            'name',
            'location',
            'addr',
            'latitude',
            'longitude',
            'guy_id'
        ]));
        return $event;
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
    public function update(Request $request, $id)
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
