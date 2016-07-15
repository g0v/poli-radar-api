<?php

namespace Api\Controllers;

use App\Viewer;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\ViewerTransformer;
use Uuid;

/**
 * @Resource('Viewers', uri='/viewer')
 */
class ViewerController extends BaseController
{

    /**
     * Show all viewers
     *
     * Get a JSON representation of all the viewers
     * 
     * @Get('/')
     */
    public function index()
    {
        return $this->response->paginator(Viewer::orderBy('id', 'desc')->paginate(10), new ViewerTransformer);
    }

    /**
     * Store a new viewer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hash = str_replace('-', '', Uuid::generate()->string);
        $viewer = Viewer::create([
            'hash' => $hash,
            'data' => $request->data,
            'user_id' => 1,
        ]);
        return $this->response->array(['hash' => $hash]);
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
    public function update(Request $request, $hash)
    {
        $data = Viewer::where('hash', $hash)->first();
        $data->update($request->only([
            'data'
        ]));
        return $this->item($data, new ViewerTransformer);
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
