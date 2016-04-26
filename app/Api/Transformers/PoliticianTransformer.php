<?php

namespace Api\Transformers;

use App\Politician;
use League\Fractal\TransformerAbstract;

class PoliticianTransformer extends TransformerAbstract
{
	public function transform(Politician $politician)
	{
		$politicianCategories = [];

        foreach ($politician->categories as $c)
        {
            $politicianCategories[] = (int) $c->id;
        }

		return [
			'id' => (int) $politician->id,
            'name' => $politician->name,
            'categories' => $politicianCategories
		];
	}
}