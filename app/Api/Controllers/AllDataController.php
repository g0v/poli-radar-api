<?php

namespace Api\Controllers;

use App\Event;
use App\Politician;
use App\PoliticianCategory;
use App\PoliticianTrait;
use App\City;
use App\Region;
use App\Http\Requests;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;
use Carbon\Carbon;

use Api\Transformers\EventTransformer;
use Api\Transformers\CityTransformer;
use Api\Transformers\RegionTransformer;
use Api\Transformers\PoliticianTransformer;
use Api\Transformers\PoliticianCategoryTransformer;
use Api\Transformers\PoliticianTraitTransformer;
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
        $cities = new FractalCollection(City::all(), new CityTransformer);
        $regions = new FractalCollection(Region::all(), new RegionTransformer);
        $politicians = new FractalCollection(Politician::all(), new PoliticianTransformer);
        $politicianCategories = new FractalCollection(PoliticianCategory::all(), new PoliticianCategoryTransformer);
        $politicianTraits = array();

        foreach (PoliticianTrait::all()->toHierarchy() as $root)
        {
            $politicianTraits[] = array(
                'id' => (int) $root->id,
                'name' => $root->name,
                'children' => $fractal->createData(new FractalCollection($root->children, new PoliticianTraitTransformer))->toArray(),
            );
        }
        $latestDate = new Carbon(DB::table('events')
                ->select(DB::raw('MAX(date) as max'))
                ->first()->max);
        $now = Carbon::now();
        $end = $now->min($latestDate);
        $endClone = clone $end;
        $start = $endClone->subDays(30);
        $events = new FractalCollection(Event::whereBetween('date', [$start, $end])->get(), new EventTransformer);

        return $this->array(array(
            'date' => [
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
            ],
            'events' => $fractal->createData($events)->toArray(),
            'politicians' => $fractal->createData($politicians)->toArray(),
            'politicianCategories' => $fractal->createData($politicianCategories)->toArray(),
            'politicianTraits' => $politicianTraits,
            'cities' => $fractal->createData($cities)->toArray(),
            'regions' => $fractal->createData($regions)->toArray(),
        ));
    }

}
