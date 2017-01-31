<?php

namespace Api\Transformers;

use App\Person;

class PersonTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'memberships',
        'events',
    ];

    public function transform(Person $person)
    {
        return [
            'id' => (int) $person->id,
            'name' => $person->name,
            'gender' => $person->gender,
            // 'born' => $person->born,
            'image' => url($person->image),
        ];
    }

    public function includeMemberships(Person $person)
    {
        return $this->collection($person->memberships, new MembershipTransformer);
    }

    public function includeEvents(Person $person)
    {
        return $this->collection($person->events, new EventTransformer);
    }
}
