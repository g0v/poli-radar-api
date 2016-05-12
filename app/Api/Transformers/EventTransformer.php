<?php

namespace Api\Transformers;

use App\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
	public function transform(Event $event)
	{
            $location = $event->location;

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

		return [
			'id' => (int) $event->id,
			'date' => $event->date,
                  'start' => $event->start,
                  'end' => $event->end,
                  'name' => $event->name,
                  'url' => $event->url,
                  'location' => $location->name,
                  'addr' => $location->address,
                  'latitude' => (float) $location->lat,
                  'longitude' => (float) $location->lng,
                  'politician' => $politicians,
                  'eventCategories' => $eventCategories,
                  'region' => (int) $event->location->region->id,
                  'city' => (int) $event->location->region->city->id,
		];
	}
}