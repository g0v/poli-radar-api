<?php

namespace Api\Transformers;

use App\Party;
use League\Fractal\TransformerAbstract;

class PartyTransformer extends TransformerAbstract
{
	/**
   * List of resources possible to include
   *
   * @var array
   */
  protected $availableIncludes = [
    'jobs',
  ];

	public function transform(Party $party)
	{
		return [
			'id' => (int) $party->id,
			'name' => $party->name,
      'color' => $party->color,
      'image' => url($party->image),
		];
	}

	/**
   * Include Jobs
   *
   * @return League\Fractal\CollectionResource
   */
  public function includeJobs(Party $party)
  {
      return $this->collection($party->jobs, new JobTransformer);
  }
}
