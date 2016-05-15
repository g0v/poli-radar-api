<?php

namespace Api\Transformers;

use App\PoliticianCategory;
use League\Fractal\TransformerAbstract;

class PoliticianCategoryTransformer extends TransformerAbstract
{
	public function transform(PoliticianCategory $pCat)
	{
		return [
			'id' => (int) $pCat->id,
            'name' => $pCat->name,
            'parent_id' => (int) $pCat->parent_id
		];
	}
}