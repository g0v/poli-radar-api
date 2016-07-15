<?php

namespace Api\Transformers;

use App\PoliticianCategory;
use League\Fractal\TransformerAbstract;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventCategoryTransformer;

class PoliticianCategoryWithNameTransformer extends TransformerAbstract
{
	public function transform(PoliticianCategory $pCat)
	{
		$politicians = [];
		if ($pCat->politicians->count()) {
			foreach ($pCat->politicians as $politician) {
				$politicians[] = [
					'id' => (int) $politician->id,
					'name' => $politician->name
				];
			}
		}
		$fractal = new Manager();
		
		$eventCategories = [];

		if ($pCat->eventCategory) {
			$eventCategories = $fractal->createData(new FractalCollection($pCat->eventCategory->leaves()->get(), new EventCategoryTransformer))->toArray();
		}
		return [
			'id' => (int) $pCat->id,
            'name' => $pCat->name,
            'politicians' => $politicians,
            'eventCategories' => $eventCategories,
		];
	}
}