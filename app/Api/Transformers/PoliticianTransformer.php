<?php

namespace Api\Transformers;

use App\Politician;
use League\Fractal\TransformerAbstract;

class PoliticianTransformer extends TransformerAbstract
{
	public function transform(Politician $politician)
	{
		
		return [
			'id' => (int) $politician->id,
            'name' => $politician->name,
            'party' => $politician->party->name
		];
	}
}