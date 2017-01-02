<?php

namespace Api\Controllers;

use App\Post;
use App\Http\Requests;

use Api\Transformers\PostTransformer;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @Resource('Posts', uri='/politicians')
 */
class PostController extends BaseController
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
        return $this->response->collection(Post::all(), new PostTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Post::create($request->only([
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
      try {
        return $this->response->item(Post::findOrFail($id), new PostTransformer);
      } catch (ModelNotFoundException $e) {
        return $this->response->errorNotFound();
      }
    }

    /**
     * Update the Post in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Post::findOrFail($id);
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
        return Post::destroy($id);
    }
}
