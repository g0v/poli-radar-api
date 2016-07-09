<?php

namespace Api\Transformers;

use App\Viewer;
use League\Fractal\TransformerAbstract;

class ViewerTransformer extends TransformerAbstract
{
	public function transform(Viewer $viewer)
	{
		return [
			'id' => (int) $viewer->id,
            'hash' => $viewer->hash,
            'data' => $viewer->data,
		];
	}
}