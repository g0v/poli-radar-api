<?php

namespace Api\V2\Transformers;

use App\Location;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    public function transform(Location $location)
    {
        return [
            'id' => $location->id,
            'name' => $location->name,
            'address' => $location->address,
            'coordinates' => [
                'lat' => $location->lat,
                'lng' => $location->lng,
            ],
        ];
    }
}
