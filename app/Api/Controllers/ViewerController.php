<?php

namespace Api\Controllers;

use App\Viewer;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\ViewerTransformer;
use Uuid;

/**
 * @Resource('Viewers', uri='/politicians')
 */
class ViewerController extends BaseController
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
        return $this->response->paginator(Viewer::orderBy('id', 'desc')->paginate(10), new ViewerTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $viewer = Viewer::create([
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
        $data = Viewer::where('hash', $hash)->first();
        if (is_null($data)) {
            $data = Viewer::find($hash);
        }
        return $this->item($data, new ViewerTransformer);
    }

    /**
     * Update the Viewer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Viewer::findOrFail($id);
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
        return Viewer::destroy($id);
    }
}
