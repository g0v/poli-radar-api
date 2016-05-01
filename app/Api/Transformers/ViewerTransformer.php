<?php

namespace Api\Transformers;

use App\Viwer;
use League\Fractal\TransformerAbstract;

class ViwerTransformer extends TransformerAbstract
{
	public function transform(Viwer $viwer)
	{

		return [
			'id' => (int) $viwer->id,
            'hash' => $viwer->uuid,
            'data' => $viwer->data,
		];
	}
}