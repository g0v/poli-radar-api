<?php

namespace Api\Transformers;

use App\Job;

class JobTransformer extends BaseTransformer
{
	/**
   * List of resources possible to include
   *
   * @var array
   */
  protected $availableIncludes = [
    'events',
  ];

	protected $defaultIncludes = [
		'party',
    'category',
  ];

	public function transform(Job $job)
	{
		return [
			'id' => (int) $job->id,
			'start' => $this->dateFormat($job->start),
      'end' => $this->dateFormat($job->end),
		];
	}

  public function includeParty(Job $job)
  {
      return $this->item($job->party, new PartyTransformer);
  }

	public function includeCategory(Job $job)
  {
      return $this->item($job->category, new PoliticianCategoryTransformer);
  }
}
