<?php

namespace Api\Transformers;

use App\PoliticianCategory;
use League\Fractal\TransformerAbstract;

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
		return [
			'id' => (int) $pCat->id,
            'name' => $pCat->name,
            'parent_id' => (int) $pCat->parent_id,
            'politicians' => $politicians,
		];
	}
}