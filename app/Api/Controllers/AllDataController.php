<?php

namespace Api\Controllers;

use App\Event;
use App\Politician;
use App\EventCategory;
use App\PoliticianCategory;
use App\Http\Requests;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventTransformer;
use Api\Transformers\PoliticianTransformer;
use Api\Transformers\EventCategoryTransformer;
use Api\Transformers\PoliticianCategoryTransformer;
use DB;

/**
 * @Resource('AllData', uri='/data')
 */
class AllDataController extends BaseController
{

    /**
     * Show all data
     *
     * Get a JSON representation of all the data
     * 
     * @Get('/')
     */
    public function index()
    {
        $fractal = new Manager();
        $events = new FractalCollection(Event::all(), new EventTransformer);
        $politicians = new FractalCollection(Politician::all(), new PoliticianTransformer);
        $eventCategories = array();
        $politicianCategories = array();

        foreach (EventCategory::all()->toHierarchy() as $root)
        {
            $eventCategories[] = array(
                'id' => (int) $root->id,
                'name' => $root->name,
                'children' => $fractal->createData(new FractalCollection($root->children, new EventCategoryTransformer))->toArray(),
            );
        }

        foreach (PoliticianCategory::all()->toHierarchy() as $root)
        {
            $politicianCategories[] = array(
                'id' => (int) $root->id,
                'name' => $root->name,
                'children' => $fractal->createData(new FractalCollection($root->children, new PoliticianCategoryTransformer))->toArray(),
            );
        }
        $date = DB::table('events')
                     ->select(DB::raw('MIN(date) as min, MAX(date) as max'))
                     ->get();
        
        return $this->array(array(
            'date' => [
                'min' => explode(" ", $date[0]->min)[0],
                'max' => explode(" ", $date[0]->max)[0]
            ],
            'events' => $fractal->createData($events)->toArray(),
            'politicians' => $fractal->createData($politicians)->toArray(),
            'eventCategories' => $eventCategories,
            'politicianCategories' => $politicianCategories
        ));
    }

}
