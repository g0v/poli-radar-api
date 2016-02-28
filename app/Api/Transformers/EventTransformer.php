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
                  'event' => $event->name,
                  'location' => $event->location,
                  'addr' => $event->addr,
                  'latitude' => (float) $event->latitude,
                  'longitude' => (float) $event->longitude,
                  'type' => $event->type_id,
                  'typeName' => $event->type->name,
                  'candidateId' => $event->candidate->id,
                  'candidate' => $event->candidate->name
		];
	}
}