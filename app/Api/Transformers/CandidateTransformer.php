<?php

namespace Api\Transformers;

use App\Candidate;
use League\Fractal\TransformerAbstract;

class CandidateTransformer extends TransformerAbstract
{
	public function transform(Candidate $candidate)
	{
		
		return [
			'id' => (int) $candidate->id,
            'name' => $candidate->name,
            'color' => $candidate->color
		];
	}
}