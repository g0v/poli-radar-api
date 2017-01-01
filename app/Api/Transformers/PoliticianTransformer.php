<?php

namespace Api\Transformers;

use App\Politician;
use League\Fractal\TransformerAbstract;

class PoliticianTransformer extends TransformerAbstract
{
	/**
   * List of resources possible to include
   *
   * @var array
   */
  protected $availableIncludes = [
    'jobs',
  ];

	public function transform(Politician $politician)
	{
		return [
			'id' => (int) $politician->id,
      'name' => $politician->name,
      'sex' => $politician->sex,
      // 'born' => $politician->born,
      'image' => url($politician->image),
		];
	}

	/**
   * Include Jobs
   *
   * @return League\Fractal\CollectionResource
   */
  public function includeJobs(Politician $politician)
  {
      return $this->collection($politician->jobs, new JobTransformer);
  }
}
