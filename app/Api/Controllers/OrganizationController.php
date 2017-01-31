<?php

namespace Api\Controllers;

use App\Organization;
use App\Http\Requests;

use Api\Transformers\OrganizationTransformer;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * @Resource('Organizations', uri='/organizations')
 */
class OrganizationController extends BaseController
{

    /**
     * Show all organizations
     *
     * Get a JSON representation of all the organizations
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->response->collection(Organization::all(), new OrganizationTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return Organization::create($request->only([
            //'name'
        //]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        return $this->response->item(Organization::findOrFail($id), new OrganizationTransformer);
      } catch (ModelNotFoundException $e) {
        return $this->response->errorNotFound();
      }
    }

    /**
     * Update the Organization in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Organization::findOrFail($id);
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
        return Organization::destroy($id);
    }
}
