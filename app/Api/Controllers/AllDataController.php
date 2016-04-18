<?php

namespace Api\Controllers;

use App\Event;
use App\Politician;
use App\Http\Requests;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventTransformer;
use Api\Transformers\PoliticianTransformer;

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
        
        return $this->array(array(
            'events' => $fractal->createData($events)->toArray(),
            'politicians' => $fractal->createData($politicians)->toArray()
        ));
    }

}
