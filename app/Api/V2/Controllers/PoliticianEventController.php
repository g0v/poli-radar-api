<?php

namespace Api\V2\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use App\Politician;
use App\Location;
use App\Event;

class PoliticianEventController extends BaseController
{
    // public function index()
    // {
    // }

    public function store(Request $request)
    {
        $json = $request->data;

        foreach ($json as $item) {
            $locationData = @$item['location']['data'];

            $location = Location::firstOrCreate([
                'name'      => @$locationData['name'],
                'address'   => @$locationData['address'],
                'lat'       => @$locationData['coordinates']['lat'],
                'lng'       => @$locationData['coordinates']['lng'],
                'region_id' => @$locationData['region_id'],
            ]);

            $date = new Carbon(@$item['date']);

            $event = Event::create([
                'name'    => @$item['name'],
                'date'    => $date->format('Y-m-d'),
                'start'   => @$item['start'],
                'end'     => @$item['end'],
                'url'     => @$item['url'],
                'location_id' => $location->id,
                'user_id' => Auth::user()->id,
            ]);

            $event->politicians()->attach($request->id);
        }
    }

    // public function show($id)
    // {
    // }

    // public function update(Request $request, $id)
    // {
    // }

    // public function destroy($id)
    // {
    // }
}
