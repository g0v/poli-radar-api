<?php

namespace Api\Controllers;

use App\Politician;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\PoliticianTransformer;

/**
 * @Resource('Politicians', uri='/politicians')
 */
class PoliticiansController extends BaseController
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
        return $this->response->collection(Politician::all(), new PoliticianTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Politician::create($request->only([
            'name',
            'party_id'
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
        return $this->item(Politician::findOrFail($id), new PoliticianTransformer);
    }

    /**
     * Update the Politician in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Politician::findOrFail($id);
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
        return Politician::destroy($id);
    }
}
