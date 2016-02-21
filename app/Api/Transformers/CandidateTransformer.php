<?php

namespace Api\Transformers;

use App\Candidate;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventTransformer;

class CandidateTransformer extends TransformerAbstract
{
	public function transform(Candidate $candidate)
	{
		$fractal = new Manager();
		$resource = new FractalCollection($candidate->events, new EventTransformer);
		
		return [
			'id' => (int) $candidate->id,
            'name' => $candidate->name,
            'color' => $candidate->color,
            'events' => $fractal->createData($resource)->toArray()
		];
	}
}