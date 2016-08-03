<?php

namespace Api\Controllers;

use Image;
use App\Politician;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\PoliticianTransformer;

/**
 * @Resource('Politicians', uri='/politicians')
 */
class PoliticiansController extends BaseController
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
        return $this->response->collection(Politician::all(), new PoliticianTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $politician = Politician::create($request->only([
            'name'
        ]));

        if (isset($request->image)) {
            $imgName = 'image/' . $politician->id . '.' . $ext;
            $img = Image::make($request->image)->resize(150, 150)->save($imgName);
            $politician->image = $imgName;
            $politician->save();
        }

        if (isset($request->categories)) {
            foreach ($request->categories as $category) {
                $politician->categories()->attach($category);
            }
        }

        return $this->item($politician, new PoliticianTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(Politician::findOrFail($id), new PoliticianTransformer);
    }

    /**
     * Update the Politician in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $politician = Politician::findOrFail($id);
        $politician->update($request->only([
            'name'
        ]));
        $newCategories = $request->categories;

        foreach ($politician->categories as $category) {
            if ($index = array_search($category->id, $newCategories)) {
                unset($newCategories[$index]);
            } else {
                $politician->categories()->detach($category->id);
            }
        }

        if (sizeof($newCategories)) {
            foreach ($newCategories as $category) {
                $politician->categories()->attach($category);
            }
        }

        return $this->item($politician, new PoliticianTransformer);
    }

    /**
     * Update the Politician in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImg(Request $request, $id)
    {
        if (isset($request->image)) {
            $politician = Politician::findOrFail($id);
            $img = Image::make($request->image)->resize(150, 150);
            $ext = explode('/', $img->mime())[1];
            $imgName = 'image/' . $politician->id . '.' . $ext;
            $img->save($imgName);
            $politician->image = $imgName;
            $politician->save();
            return $this->item($politician, new PoliticianTransformer);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Politician::destroy($id);
    }
}
