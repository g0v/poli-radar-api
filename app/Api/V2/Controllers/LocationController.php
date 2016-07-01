<?php

namespace Api\V2\Controllers;

use \Illuminate\Http\Request;

use App\Location;
use Api\V2\Transformers\LocationTransformer;

/**
 * @Resource('Locations', uri='/locations')
 */
class LocationController extends BaseController
{

    /**
     * Show all politicians
     *
     * Get a JSON representation of all the politicians
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->response->collection(Location::all(), new LocationTransformer);
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
            'name' => $request->name,
            'address' => $request->address,
            'lat' => $request->coordinates['lat'],
            'lng' => $request->coordinates['lng'],
            'region_id' => $request->region_id,
        ]);

        return $this->response->created($location);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->item(Location::findOrFail($id), new LocationTransformer);
    }

    /**
     * Update the Location in the database.
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
