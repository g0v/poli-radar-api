<?php

namespace Api\Controllers;

use App\Role;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\RoleTransformer;

/**
 * @Resource('Roles', uri='/politicians')
 */
class RoleController extends BaseController
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
        return $this->response->collection(Role::all(), new RoleTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $viewer = Role::create([
            'hash' => str_replace('-', '', Uuid::generate()->string),
            'data' => $request->data,
            'user_id' => 1,
        ]);
        return $this->response->array(['hash' => $viewer->hash]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($hash)
    {
        return $this->item(Role::where('hash', '=', $hash)->firstOrFail(), new RoleTransformer);
    }

    /**
     * Update the Role in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Role::findOrFail($id);
        $candidate->update($request->only([
            'data'
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
        return Role::destroy($id);
    }
}
