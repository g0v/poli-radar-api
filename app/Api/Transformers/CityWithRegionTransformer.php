<?php

namespace Api\Transformers;

use App\City;
use League\Fractal\TransformerAbstract;

class CityWithRegionTransformer extends TransformerAbstract
{
	public function transform(City $city)
	{
		$regions = [];
		$events = [];

		foreach ($city->regions as $region) {

			$regions[] = [
				'id' => (int) $region->id,
				'name' => $region->name,
			];

			foreach ($region->locations as $location)
	        {
	            foreach ($location->events as $e) {
	            	$events[] = (int) $e->id;
	            }
	        }
	    }
		
		return [
			'id' => (int) $city->id,
            'name' => $city->name,
            'regions' => $regions,
            'events' => $events,
		];
	}
}