<?php

namespace Api\Transformers;

use App\Post;

class PostTransformer extends BaseTransformer
{
	/**
   * List of resources possible to include
   *
   * @var array
   */
  protected $availableIncludes = [
    'memberships',
		'organization',
		'classification',
  ];


	public function transform(Post $post)
	{
		return [
			'id' => (int) $post->id,
			'label' => $post->label,
			'start' => $this->dateFormat($post->start),
      'end' => $this->dateFormat($post->end),
		];
	}

  public function includeOrganization(Post $post)
  {
      return $this->item($post->organization, new OrganizationTransformer);
  }

	public function includeMemberships(Post $post)
  {
      return $this->collection($post->memberships, new MembershipTransformer);
  }

	public function includeClassification(Post $post)
  {
		  if (is_null($post->classification)) return $this->null();
      return $this->item($post->classification, new PostClassificationTransformer);
  }
}
