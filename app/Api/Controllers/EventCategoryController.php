<?php

namespace Api\Controllers;

use App\EventCategory;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\EventCategoryTransformer;

/**
 * @Resource('EventCategorys', uri='/politicians')
 */
class EventCategoryController extends BaseController
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
        return $this->response->collection(EventCategory::all(), new EventCategoryTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parent = EventCategory::find($request->parent_id);
        $newCate = EventCategory::firstOrCreate([
            'parent_id' => (int) $request->parent_id,
            'name' =>$request->name,
        ]);
        $newCate->makeChildOf($parent);

        return $this->item($newCate, new EventCategoryTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(EventCategory::findOrFail($id), new EventCategoryTransformer);
    }

    /**
     * Update the EventCategory in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = EventCategory::findOrFail($id);
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
        return EventCategory::destroy($id);
    }

    public function find($name)
    {
        return $this->item(
            EventCategory::where('parent_id', null)
            ->where('name', $name)
            ->first()
        , new EventCategoryTransformer);
    }
}
