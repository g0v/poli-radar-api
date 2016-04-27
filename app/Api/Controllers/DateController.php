<?php

namespace Api\Controllers;

use App\Event;
use App\Http\Requests;
use Illuminate\Http\Request;
use Api\Transformers\PoliticianTransformer;
use DB;
/**
 * @Resource('Politicians', uri='/date')
 */
class DateController extends BaseController
{

    /**
     * Show all date
     *
     * Get a JSON representation of all the date
     * 
     * @Get('/')
     */
    public function index()
    {
        $date = DB::table('events')
                     ->select(DB::raw('MIN(date) as min, MAX(date) as max'))
                     ->get();


        return $this->array([
            'min' => explode(" ", $date[0]->min)[0],
            'max' => explode(" ", $date[0]->max)[0]
        ]);
        
    }

}
