<?php

namespace Api\Transformers;

use App\EventCategory;
use League\Fractal\TransformerAbstract;

class EventCategoryTransformer extends TransformerAbstract
{
	public function transform(EventCategory $eCat)
	{
		$parent = $eCat->parent()->first();

		if (is_null($parent)) {
			$parentArray = [];
		} else {
			$parentArray = [
				'id' => (int) $parent->id,
				'name' => $parent->name,
			];
		}

		return [
			'id' => (int) $eCat->id,
            'name' => $eCat->name,
			'parent' => $parentArray
		];
	}
}
