<?php

namespace Api\Controllers;

use App\PostClassification;
use App\Http\Requests;

use Api\Transformers\PostClassificationTransformer;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @Resource('PostClassifications', uri='/politicians')
 */
class PostClassificationController extends BaseController
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
        return $this->response->collection(PostClassification::all(), new PostClassificationTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return PostClassification::create($request->only([
            'name'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($query)
    {
      try {
        $item = PostClassification::findOrFail((int) $query);
      } catch (ModelNotFoundException $e) {
        try {
          $item = PostClassification::where('name', $query)->firstOrFail();
        } catch (ModelNotFoundException $e) {
          return $this->response->errorNotFound();
        }
      }
      return $this->response->item($item, new PostClassificationTransformer);
    }

    /**
     * Update the PostClassification in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = PostClassification::findOrFail($id);
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
        return PostClassification::destroy($id);
    }
}
