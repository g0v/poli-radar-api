<?php

namespace Api\Transformers;

use App\EventCategory;
use League\Fractal\TransformerAbstract;

class EventCategoryTransformer extends TransformerAbstract
{
	public function transform(EventCategory $eCat)
	{
		
		return [
			'id' => (int) $eCat->id,
            'name' => $eCat->name,
		];
	}
}