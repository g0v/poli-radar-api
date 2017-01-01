<?php

namespace Api\Transformers;

use App\PostClassification;

class PostClassificationTransformer extends BaseTransformer
{
	protected $defaultIncludes = [
		'event_category',
	];

	public function transform(PostClassification $pCat)
	{
		return [
			'id' => (int) $pCat->id,
      'name' => $pCat->name,
		];
	}

	public function includeEventCategory(PostClassification $pCat)
  {
    return $this->item($pCat->eventCategory, new EventCategoryTransformer);
  }
}
