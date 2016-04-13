<?php

namespace Api\Controllers;

use App\Activity;
use App\Guy;
use App\Http\Requests;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\ActivityTransformer;
use Api\Transformers\GuyTransformer;

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
        $activities = new FractalCollection(Activity::all(), new ActivityTransformer);
        $candidates = new FractalCollection(Guy::all(), new GuyTransformer);
        
        return $this->array(array(
            'activities' => $fractal->createData($activities)->toArray(),
            'guys' => $fractal->createData($candidates)->toArray()
        ));
    }

}
