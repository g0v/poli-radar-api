<?php

namespace Api\Transformers;

use App\Event;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

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
			$parent = $c->parent()->first();
			$eventCategories[] = [
				'id' => (int) $c->id,
				'name' => $c->name,
				'parent' => [
					'id' => (int) $parent->id,
					'name' => $parent->name,
				]
			];
        }

        $location = $event->location;
        $locationData = [];
        if ($location) {
              $locationData = [
                    'location' => $location->name,
                    'addr' => $location->address,
                    'latitude' => (float) $location->lat,
                    'longitude' => (float) $location->lng,
                    'region' => (int) $location->region->id,
                    'city' => (int) $location->region->city->id,
              ];
        }
        $date = new Carbon($event->date);

		return array_merge([
			'id' => (int) $event->id,
			'date' => $date->format('Y-m-d'),
                  'start' => $event->start,
                  'end' => $event->end,
                  'name' => $event->name,
                  'url' => $event->url,
                  'politicians' => $politicians,
                  'eventCategories' => $eventCategories,
		], $locationData);
	}
}
