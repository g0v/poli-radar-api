<?php

namespace Api\Controllers;

use DB;
use Auth;
use App\Event;
use App\Region;
use App\Location;
use App\Politician;
use App\EventCategory;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Api\Requests\EventRequest;
use Api\Transformers\EventTransformer;
use Api\Transformers\PoliticianTransformer;

use Carbon\Carbon;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function checkDateCount($event, $ids, $eventCategories)
{
    $pIds = [];
    $eCats = [];
    foreach ($event->politicians as $p) {
        $pIds[] = $p->id;
    }
    foreach ($event->categories as $cat) {
        $eCats[] = $cat->id;
    }
    if (array_intersect($pIds, $ids) && array_intersect($eCats, $eventCategories)) {
        return true;
    }
    return false;
}

function parseAddress($address)
{
    $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
    $geocoder = new \Geocoder\Provider\GoogleMaps(
        $curl,
        'zh-tw',
        'tw',
        true,
        'AIzaSyBGogPR8JvLm5xC8xGwSTCpKkXm5eZFVH4'
    );

    $geoResults = $geocoder->geocode($address)->first();

    return $geoResults;
}

/**
 * @Resource('Events', uri='/events')
 */
class EventsController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->has('all')) {
            return $this->response->collection(Event::all(), new EventTransformer);
        } else {
            if ($request->has('politician') && $request->has('eventCategories')) {
                foreach (Event::orderBy('date', 'desc')->get() as $event) {
                    if (checkDateCount($event, $request->politician, $request->eventCategories)) {
                        $end = new Carbon($event->date);
                        break;
                    }
                }
            } else {
                $latestDate = new Carbon(DB::table('events')
                    ->select(DB::raw('MAX(date) as max'))
                    ->first()->max);

                $now = Carbon::now();

                $end = $now->min($latestDate);
            }

            if ($request->has('end')) {
                $end = new Carbon($request->end);
            }

            if ($request->has('start')) {
                $start = new Carbon($request->start);
            } else {
                $endClone = clone $end;
                $start = $endClone->subDays(30);
            }

            if ($request->has('politician')) {
                if ($request->has('start') && $request->has('end')) {
                    $politician = Politician::with(['events' => function ($query) use ($request) {
                        $query->whereBetween('date', [$request->start, $request->end])
                          ->with('categories')
                          ->with('location');
                    }])->find($request->politician);
                } else if ($request->has('start')) {
                    $politician = Politician::with(['events' => function ($query) use ($request) {
                        $query->where('date', '>', $request->start)
                          ->with('categories')
                          ->with('location');
                    }])->find($request->politician);
                } else if ($request->has('end')) {
                    $politician = Politician::with(['events' => function ($query) use ($request) {
                        $query->whereBetween('date', '<',$request->end)
                          ->with('categories')
                          ->with('location');
                    }])->find($request->politician);
                } else {
                  $politician = Politician::with(['events' => function ($query) use ($request) {
                      $query->with('categories')
                        ->with('location');
                    }])->find($request->politician);
                }

                return $this->response->item($politician, new PoliticianTransformer);
            }

            $fractal = new Manager();

            $events = new FractalCollection(Event::whereBetween('date', [$start, $end])->get(), new EventTransformer);

            return $this->array([
                'events' => $fractal->createData($events)->toArray(),
                'date' => [
                    'start' => $start->format('Y-m-d'),
                    'end' => $end->format('Y-m-d'),
                ]
            ]);
        }
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
            'name'      => $request->location,
        ]);

        $date = new Carbon($request->date);

        $event = Event::create([
            'date'    => $date->format('Y-m-d'),
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
        $geoResults = parseAddress($request->address);
        $region = Region::where('postal_code', $geoResults->getPostalCode())->first();
        $date = new Carbon($request->date);

        if ($region) {
            $location = Location::firstOrCreate([
                'address'   => $request->address,
                'lat'       => $geoResults->getLatitude(),
                'lng'       => $geoResults->getLongitude(),
                'region_id' => $region->id,
                'name'      => $request->location,
            ]);
            $event = Event::firstOrCreate([
                'date'    => $date->format('Y-m-d'),
                'name'    => $request->name,
                'location_id' => $location->id,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $event = Event::firstOrCreate([
                'date'    => $date->format('Y-m-d'),
                'name'    => $request->name,
                'user_id' => Auth::user()->id
            ]);
        }

        $event->url = $request->url;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->description = $request->description;
        $event->save();

        $eventTypeRoot = EventCategory::where(['name' => $request->politicianCategory])->first();
        $eventType = EventCategory::firstOrCreate([
            'parent_id' => (int) $eventTypeRoot->id,
            'name' => $request->category == '' ? '無分類' : $request->category,
        ]);
        $eventType->makeChildOf($eventTypeRoot);

        $event->categories()->detach();
        $event->categories()->attach($eventType->id);

        // must detach ?
        $event->politicians()->detach();
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
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->url = $request->url;

        $geoResults = parseAddress($request->address);

        $region = Region::where('postal_code', $geoResults->getPostalCode())->first();
        $location = Location::firstOrCreate([
            'address'   => $request->address,
            'lat'       => $geoResults->getLatitude(),
            'lng'       => $geoResults->getLongitude(),
            'region_id' => $region->id,
            'name'      => $request->location,
        ]);
        $event->location_id = $location->id;
        $event->save();

        $eventTypeRoot = EventCategory::where(['name' => $request->politicianCategory])->first();
        $eventType = EventCategory::firstOrCreate([
            'parent_id' => $eventTypeRoot->id,
            'name' => $request->category == '' ? '無分類' : $request->category,
        ]);
        $eventType->makeChildOf($eventTypeRoot);

        $event->categories()->detach();
        $event->categories()->attach($eventType->id);

        // must detach ?
        $event->politicians()->detach();
        $event->politicians()->attach($request->politician);

        return response()->json([
            'status' => '201'
        ]);
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
