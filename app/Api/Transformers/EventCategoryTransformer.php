<?php

namespace Api\Transformers;

use App\EventCategory;

class EventCategoryTransformer extends BaseTransformer
{
	protected $defaultIncludes = [
		'parent',
  ];

	public function transform(EventCategory $eCat)
	{
		return [
			'id' => (int) $eCat->id,
			'name' => $eCat->name,
		];
	}

	public function includeParent(EventCategory $eCat)
	{
		$parent = $eCat->parent()->first();
		if (is_null($parent)) {
			return $this->null();
		}
		return $this->item($parent, new EventCategoryTransformer);
	}
}
