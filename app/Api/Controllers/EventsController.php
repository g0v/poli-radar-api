<?php

namespace Api\Controllers;

use Auth;
use App\Event;
use App\Region;
use App\Location;
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

    public function index()
    {
        return $this->response->collection(Event::all(), new EventTransformer);
    }

    public function date($start = null, $end = null)
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
        $location = Location::firstOrCreate([
            'address'   => $request->address,
            'lat'       => $request->latitude,
            'lng'       => $request->longitude,
            'region_id' => $request->region,
        ]);
        if ($request->location) {
            $location->name = $request->location;
            $location->save();
        }
        $event = Event::create([
            'date'    => $request->date,
            'start'   => $request->start,
            'end'     => $request->end,
            'name'    => $request->name,
            'url'     => $request->url,
            'location_id' => $location->id,
            'user_id' => Auth::user()->id
        ]);
        $event->politicians()->attach($request->politician);
        return item($event, new EventTransformer);
    }

    public function batchStore(Request $request)
    {
        $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\GoogleMaps(
            $curl,
            'zh-tw',
            'tw',
            true,
            'AIzaSyBGogPR8JvLm5xC8xGwSTCpKkXm5eZFVH4'
        );

        $geoResults = $geocoder->geocode($request->city.$request->region.$request->address)->first();

        $region = Region::where('name', $request->region)->first();
        if (!$region) {
            $region = Region::where('postal_code', $geoResults->getPostalCode())->first();
            if (!$region) {
                return response()->json(['error' => 'no_region_data_provided'], 409); 
            }
        }

        $location = Location::firstOrCreate([
            'address'   => $request->address,
            'lat'       => $geoResults->getLatitude(),
            'lng'       => $geoResults->getLongitude(),
            'region_id' => $region->id,
        ]);
        if ($request->location) {
            $location->name = $request->location;
            $location->save();
        }
        $event = Event::firstOrCreate([
            'date'    => $request->date,
            'start'   => $request->start,
            'end'     => $request->end,
            'name'    => $request->name,
            'url'     => $request->url,
            'location_id' => $location->id,
            'user_id' => Auth::user()->id
        ]);
        $event->politicians()->attach($request->politician);
        return $this->item($event, new EventTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(Event::findOrFail($id), new EventTransformer);
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
