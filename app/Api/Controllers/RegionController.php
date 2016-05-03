<?php

namespace Api\Controllers;

use App\Region;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\RegionTransformer;

/**
 * @Resource('Regions', uri='/politicians')
 */
class RegionController extends BaseController
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
        return $this->response->collection(Region::all(), new RegionTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Region::create($request->only([
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
        return $this->item(Region::findOrFail($id), new RegionTransformer);
    }

    /**
     * Update the Region in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Region::findOrFail($id);
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
        return Region::destroy($id);
    }
}
