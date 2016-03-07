<?php

namespace Api\Controllers;

use App\Type;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\TypeTransformer;

/**
 * @Resource('Types', uri='/candidates')
 */
class TypesController extends BaseController
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
        return $this->response->collection(Type::all(), new TypeTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        return Type::create($request->only([
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
        return $this->item(Type::findOrFail($id), new TypeTransformer);
    }

    /**
     * Update the Type in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        $candidate = Type::findOrFail($id);
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
        return Type::destroy($id);
    }
}
