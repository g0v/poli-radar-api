<?php

namespace Api\Controllers;

use App\Location;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\LocationTransformer;

/**
 * @Resource('Locations', uri='/politicians')
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
        return Location::create($request->only([
            'name'
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
        return $this->item(Location::findOrFail($id), new LocationTransformer);
    }

    /**
     * Update the Location in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Location::findOrFail($id);
        $candidate->update($request->only([
            'name'
        ]));
        return $candidate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Location::destroy($id);
    }
}
