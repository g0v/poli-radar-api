<?php
namespace Api\V2\Transformers;

use App\PoliticianCategory;
use League\Fractal\TransformerAbstract;

class PoliticianCategoryTransformer extends TransformerAbstract
{
	public function transform(PoliticianCategory $category)
	{
	    return [
	        'id' => (int) $category->id,
			'name' => $category->name,
	    ];
	}
}
