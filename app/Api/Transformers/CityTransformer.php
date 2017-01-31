<?php

namespace Api\Transformers;

use App\City;
use League\Fractal\TransformerAbstract;

class CityTransformer extends TransformerAbstract
{
    public function transform(City $city)
    {
        $regions = [];
        $events = [];

        foreach ($city->regions as $region) {

            $regions[] = (int) $region->id;

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
