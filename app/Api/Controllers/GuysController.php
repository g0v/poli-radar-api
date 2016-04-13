<?php

namespace Api\Controllers;

use App\Guy;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\GuyTransformer;

/**
 * @Resource('Guys', uri='/candidates')
 */
class GuysController extends BaseController
{

    /**
     * Show all candidates
     *
     * Get a JSON representation of all the candidates
     * 
     * @Get('/')
     */
    public function index()
    {
        return $this->response->collection(Guy::all(), new GuyTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Guy::create($request->only([
            'name',
            'color'
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
        return $this->item(Guy::findOrFail($id), new GuyTransformer);
    }

    /**
     * Update the Guy in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Guy::findOrFail($id);
        $candidate->update($request->only([
            'name',
            'color'
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
        return Guy::destroy($id);
    }
}
