<?php

namespace Api\Transformers;

use App\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
	public function transform(Event $event)
	{
            $politicians = [];
            foreach ($event->politicians as $p)
            {
                  $politicians[] = (int) $p->id;
            }

            $eventCategories = [];
            foreach ($event->categories as $c)
            {
                  $eventCategories[] = (int) $c->id;
            }

            $location = $event->location;
            $locationData = [];
            if ($location) {
                  $locationData = [
                        'location' => $location->name,
                        'addr' => $location->address,
                        'latitude' => (float) $location->lat,
                        'longitude' => (float) $location->lng,
                        'politician' => $politicians,
                        'region' => (int) $location->region->id,
                        'city' => (int) $location->region->city->id,
                  ];
            }

		return array_merge([
			'id' => (int) $event->id,
			'date' => $event->date,
                  'start' => $event->start,
                  'end' => $event->end,
                  'name' => $event->name,
                  'url' => $event->url,
                  'eventCategories' => $eventCategories,
		], $locationData);
	}
}