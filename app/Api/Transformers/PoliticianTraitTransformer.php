<?php

namespace Api\Transformers;

use App\PoliticianTrait;
use League\Fractal\TransformerAbstract;

class PoliticianTraitTransformer extends TransformerAbstract
{
	public function transform(PoliticianTrait $pTrait)
	{
		return [
			'id' => (int) $pTrait->id,
			'name' => $pTrait->name,
			'parent_id' => (int) $pTrait->parent_id
		];
	}
}