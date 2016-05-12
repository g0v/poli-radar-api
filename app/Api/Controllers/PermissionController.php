<?php

namespace Api\Controllers;

use App\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\PermissionTransformer;

/**
 * @Resource('Permissions', uri='/politicians')
 */
class PermissionController extends BaseController
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
        return $this->response->collection(Permission::all(), new PermissionTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $viewer = Permission::create([
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
        return $this->item(Permission::where('hash', '=', $hash)->firstOrFail(), new PermissionTransformer);
    }

    /**
     * Update the Permission in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Permission::findOrFail($id);
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
        return Permission::destroy($id);
    }
}
