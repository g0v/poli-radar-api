<?php

namespace Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	public function transform(User $user)
	{
		$roles = [];
		foreach ($user->roles as $role) {
			$roles[] = $role->name;
		}
		return [
			'id' => (int) $user->id,
            'username' => $user->name,
            'email' => $user->email,
            'roles' => $roles
		];
	}
}