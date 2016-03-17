<?php

namespace Api\Controllers;

use App\Candidate;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\CandidateTransformer;

/**
 * @Resource('Candidates', uri='/candidates')
 */
class CandidatesController extends BaseController
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
        return $this->response->collection(Candidate::all(), new CandidateTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Candidate::create($request->only([
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
        return $this->item(Candidate::findOrFail($id), new CandidateTransformer);
    }

    /**
     * Update the Candidate in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);
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
        return Candidate::destroy($id);
    }
}
