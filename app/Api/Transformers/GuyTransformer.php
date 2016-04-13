<?php

namespace Api\Transformers;

use App\Guy;
use League\Fractal\TransformerAbstract;

class GuyTransformer extends TransformerAbstract
{
	public function transform(Guy $guy)
	{
		
		return [
			'id' => (int) $guy->id,
            'name' => $guy->name,
            'color' => $guy->color
		];
	}
}