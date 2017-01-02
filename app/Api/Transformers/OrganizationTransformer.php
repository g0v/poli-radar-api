<?php

namespace Api\Transformers;

use App\Organization;

class OrganizationTransformer extends BaseTransformer
{
	/**
   * List of resources possible to include
   *
   * @var array
   */
  protected $availableIncludes = [
    'classification',
  ];

	public function transform(Organization $organization)
	{
		return [
			'id' => (int) $organization->id,
			'name' => $organization->name,
      'image' => url($organization->image),
		];
	}

	public function includeClassification(Organization $organization)
  {
		if (is_null($organization->classification)) return $this->null();
    return $this->item($organization->classification, new OrganizationClassificationTransformer);
  }
}
