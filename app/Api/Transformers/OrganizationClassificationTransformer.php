<?php

namespace Api\Transformers;

use App\OrganizationClassification;

class OrganizationClassificationTransformer extends BaseTransformer
{
	public function transform(OrganizationClassification $oClass)
	{
		return [
			'id' => (int) $oClass->id,
      'name' => $oClass->name,
		];
	}

}
