<?php

namespace Api\Transformers;

use App\Activity;
use League\Fractal\TransformerAbstract;

class ActivityTransformer extends TransformerAbstract
{
	public function transform(Activity $activity)
	{
		return [
			'id' => (int) $activity->id,
			'date' => $activity->date,
                  'start' => $activity->start,
                  'end' => $activity->end,
                  'name' => $activity->name,
                  'location' => $activity->location,
                  'addr' => $activity->addr,
                  'latitude' => (float) $activity->latitude,
                  'longitude' => (float) $activity->longitude,
                  'type' => $activity->tags,
                  'guyId' => (int) $activity->guy->id,
                  'guy' => $activity->guy->name
		];
	}
}