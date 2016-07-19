<?php

namespace Api\Transformers;

use App\EventCategory;
use League\Fractal\TransformerAbstract;

class EventCategoryTransformer extends TransformerAbstract
{
	public function transform(EventCategory $eCat)
	{
		$parent = $eCat->parent()->get();

		return [
			'id' => (int) $eCat->id,
            'name' => $eCat->name,
			'parent' => [
				'id' => (int) $parent->id,
				'name' => $parent->name,
			]
		];
	}
}
