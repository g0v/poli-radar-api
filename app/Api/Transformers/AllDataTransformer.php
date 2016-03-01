<?php

namespace Api\Transformers;

use App\Type;
use App\Event;
use App\Candidate;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Manager;

use Api\Transformers\EventTransformer;

class AllDataTransformer extends TransformerAbstract
{
	public function transform($data)
	{
		$fractal = new Manager();
		$activities = new FractalCollection($data->activities, new EventTransformer);
		
		return [
            'activities' => $fractal->createData($activities)->toArray()
		];
	}
}