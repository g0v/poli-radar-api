<?php

namespace Api\Transformers;

use App\Region;
use League\Fractal\TransformerAbstract;

class RegionTransformer extends TransformerAbstract
{
    public function transform(Region $region)
    {
        $events = [];

        foreach ($region->locations as $location)
        {
            foreach ($location->events as $e) {
                $events[] = (int) $e->id;
            }
        }

        return [
            'id'     => (int) $region->id,
            'city'   => (int) $region->city->id,
            'name'   => $region->name,
            'events' => $events,
        ];
    }
}
