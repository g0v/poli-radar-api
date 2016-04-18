<?php

namespace Api\Transformers;

use App\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
	public function transform(Event $event)
	{
            $location = $event->location;
		return [
			'id' => (int) $event->id,
			'date' => $event->date,
                  'start' => $event->start,
                  'end' => $event->end,
                  'name' => $event->name,
                  'location' => $location->name,
                  'addr' => $location->address,
                  'latitude' => (float) $location->lat,
                  'longitude' => (float) $location->lng
		];
	}
}