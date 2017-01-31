<?php

namespace Api\Transformers;

use App\Location;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    public function transform(Location $location)
    {
        $events = [];

        foreach ($location->events as $e)
        {
            $events[] = (int) $e->id;
        }

        return [
            'id' => (int) $location->id,
            'name' => $location->name,
            'events' => $events,
        ];
    }
}
