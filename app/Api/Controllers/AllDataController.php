<?php

namespace Api\Controllers;

use App\Event;
use App\Party;
use App\Politician;
use App\EventCategory;
use App\PoliticianCategory;
use App\Http\Requests;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventTransformer;
use Api\Transformers\PartyTransformer;
use Api\Transformers\PoliticianTransformer;
use Api\Transformers\EventCategoryTransformer;
use Api\Transformers\PoliticianCategoryTransformer;

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
        $parties = new FractalCollection(Party::all(), new PartyTransformer);
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
        
        return $this->array(array(
            'events' => $fractal->createData($events)->toArray(),
            'parties' => $fractal->createData($parties)->toArray(),
            'politicians' => $fractal->createData($politicians)->toArray(),
            'eventCategories' => $eventCategories,
            'politicianCategories' => $politicianCategories
        ));
    }

}
