<?php

namespace Api\Transformers;

use App\Membership;

class MembershipTransformer extends BaseTransformer
{
	/**
   * List of resources possible to include
   *
   * @var array
   */
  protected $availableIncludes = [
    'post',
		'organization',
		'person',
  ];


	public function transform(Membership $membership)
	{
		return [
			'id' => (int) $membership->id,
			'label' => $membership->label,
			'start' => $this->dateFormat($membership->start),
      'end' => $this->dateFormat($membership->end),
		];
	}

  public function includeOrganization(Membership $membership)
  {
      return $this->item($membership->organization, new OrganizationTransformer);
  }

	public function includePost(Membership $membership)
  {
      if (is_null($membership->post)) return $this->null();
      return $this->item($membership->post, new PostTransformer);
  }

  public function includePerson(Membership $membership)
  {
      return $this->item($membership->person, new PersonTransformer);
  }
}
