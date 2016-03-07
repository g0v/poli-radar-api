<?php

namespace Api\Controllers;

use App\Type;
use App\Event;
use App\Candidate;
use App\Http\Requests;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\TypeTransformer;
use Api\Transformers\EventTransformer;
use Api\Transformers\CandidateTransformer;

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
        $activities = new FractalCollection(Event::all(), new EventTransformer);
        $candidates = new FractalCollection(Candidate::all(), new CandidateTransformer);
        $categories = new FractalCollection(Type::all(), new TypeTransformer);
        
        return $this->array(array(
            'activities' => $fractal->createData($activities)->toArray(),
            'guys' => $fractal->createData($candidates)->toArray(),
            'categories' => $fractal->createData($categories)->toArray()
        ));
    }

}
