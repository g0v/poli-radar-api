<?php

namespace Api\Transformers;

use App\Type;
use League\Fractal\TransformerAbstract;

class TypeTransformer extends TransformerAbstract
{
	public function transform(Type $type)
	{
		return [
			'id' => (int) $type->id,
            'name' => $type->name
		];
	}
}