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
        'memberships',
        'posts',
    ];

    public function transform(Organization $organization)
    {
        return [
            'id' => (int) $organization->id,
            'name' => $organization->name,
            'image' => url($organization->image),
            'parent_id' => (int) $organization->parent_id,
            'classification' => $organization->classification,
        ];
    }

    public function includeMemberships(Organization $organization)
    {
        return $this->collection($organization->members, new MembershipTransformer);
    }

    public function includePosts(Organization $organization)
    {
        return $this->collection($organization->posts, new PostTransformer);
    }
}
