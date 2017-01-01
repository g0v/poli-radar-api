<?php

namespace Api\Transformers;

use App\PoliticianCategory;

class PoliticianCategoryTransformer extends BaseTransformer
{
	protected $defaultIncludes = [
		'event_category',
	];

	public function transform(PoliticianCategory $pCat)
	{
		return [
			'id' => (int) $pCat->id,
      'name' => $pCat->name,
		];
	}

	public function includeEventCategory(PoliticianCategory $pCat)
  {
    return $this->item($pCat->eventCategory, new EventCategoryTransformer);
  }
}
