<?php

namespace Api\Transformers;

use App\Party;
use League\Fractal\TransformerAbstract;

class PartyTransformer extends TransformerAbstract
{
	public function transform(Party $party)
	{
		$members = [];

        foreach ($party->members as $m)
        {
            $members[] = (int) $m->id;
        }

		return [
			'id' => (int) $party->id,
            'name' => $party->name,
            'members' => $members
		];
	}
}