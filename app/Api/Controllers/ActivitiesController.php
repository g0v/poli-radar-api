<?php

namespace Api\Controllers;

use App\Activity;
use App\Http\Requests;
use Illuminate\Http\Request;
// use Api\Requests\ActivityRequest;
use Api\Transformers\ActivityTransformer;

/**
 * @Resource('Activities', uri='/events')
 */
class ActivitiesController extends BaseController
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
        return $this->collection(Activity::all(), new ActivityTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activity = Activity::create($request->only([
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
        return $activity;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(Activity::findOrFail($id));
    }

    /**
     * Update the Activity in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->update($request->only([
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
        return $activity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Activity::destroy($id);
    }
}
