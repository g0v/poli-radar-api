<?php

namespace Api\Controllers;

use App\Politician;
use App\PoliticianCategory;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\PoliticianCategoryTransformer;
use Api\Transformers\PoliticianCategoryWithNameTransformer;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

/**
 * @Resource('PoliticianCategorys', uri='/politicians')
 */
class PoliticianCategoryController extends BaseController
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
        return $this->response->collection(PoliticianCategory::all(), new PoliticianCategoryTransformer);
    }

    public function withNames()
    {
        return $this->response->collection(PoliticianCategory::all(), new PoliticianCategoryWithNameTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parent = PoliticianCategory::find($request->parent_id);
        $parent->children()->create(['name' => $request->name]);

        return $this->item($node, new PoliticianCategoryTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(PoliticianCategory::findOrFail($id), new PoliticianCategoryTransformer);
    }

    /**
     * Update the PoliticianCategory in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $politicianCategory = PoliticianCategory::findOrFail($id);
        $politicianCategory->update($request->only([
            'name',
            'parent_id'
        ]));
        return $politicianCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return PoliticianCategory::destroy($id);
    }
}
