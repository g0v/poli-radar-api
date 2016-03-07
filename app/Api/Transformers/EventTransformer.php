<?php

namespace Api\Transformers;

use App\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
	public function transform(Event $event)
	{
		return [
			'id' => (int) $event->id,
			'date' => $event->date,
                  'start' => $event->start,
                  'end' => $event->end,
                  'name' => $event->name,
                  'location' => $event->location,
                  'addr' => $event->addr,
                  'latitude' => (float) $event->latitude,
                  'longitude' => (float) $event->longitude,
                  'type' => (int) $event->type_id,
                  'typeName' => $event->type->name,
                  'guyId' => (int) $event->candidate->id,
                  'guy' => $event->candidate->name
		];
	}
}