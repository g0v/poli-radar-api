<?php

namespace Api\Transformers;

use App\PoliticianCategory;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventCategoryTransformer;

class PoliticianCategoryTransformer extends TransformerAbstract
{
	public function transform(PoliticianCategory $pCat)
	{
		$fractal = new Manager();
		$eventCategories = [];

		if ($pCat->eventCategory) {
			$eventCategories = $fractal->createData(new FractalCollection($pCat->eventCategory->leaves(), new EventCategoryTransformer))->toArray();
		}

		return [
			'id' => (int) $pCat->id,
            'name' => $pCat->name,
            'event_categories' => $eventCategories,
		];
	}
}
