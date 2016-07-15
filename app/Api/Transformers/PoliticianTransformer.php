<?php

namespace Api\Transformers;

use App\Politician;
use League\Fractal\TransformerAbstract;

class PoliticianTransformer extends TransformerAbstract
{
	public function transform(Politician $politician)
	{
		$politicianCategories = [];
		$politicianTraits = [];

        foreach ($politician->categories as $c)
        {
            $politicianCategories[] = (int) $c->id;
        }

        foreach ($politician->traits as $t)
        {
            $politicianTraits[] = (int) $t->id;
        }

		return [
			'id' => (int) $politician->id,
            'name' => $politician->name,
            'categories' => $politicianCategories,
            'traits' => $politicianTraits,
            'hasData' => (bool) $politician->events->count(),
			'events' => $politician->events,
		];
	}
}
