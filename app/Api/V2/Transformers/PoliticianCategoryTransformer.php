<?php
namespace Api\V2\Transformers;

use App\Politician;
use App\PoliticianCategory;
use App\EventCategory;

use League\Fractal;

use Api\V2\Transformers\PoliticianTransformer;
use Api\V2\Transformers\EventCategoryTransformer;

class PoliticianCategoryTransformer extends Fractal\TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'politicians',
		'eventCategory',
    ];

	public function transform(PoliticianCategory $category)
	{
		$fractal = new Fractal\Manager();
		if (isset($_GET['include'])) {
			$fractal->parseIncludes($_GET['include']);
		};

	    return [
	        'id' => (int) $category->id,
			'name' => $category->name,
	    ];
	}

	public function includePoliticians(PoliticianCategory $category)
	{
		$politicians = $category
			->politicians()
			->where('politician_category_id', '=', $category->id)
			->get();

		return $this->collection($politicians, new PoliticianTransformer);
	}

	public function includeEventCategory(PoliticianCategory $category)
	{
		if (is_null($category->eventCategory)) return $this->collection([], new EventCategoryTransformer);

		$eventCategories = $category
			->eventCategory
			->leaves()
			->get();

		return $this->collection($eventCategories, new EventCategoryTransformer);
	}
}
